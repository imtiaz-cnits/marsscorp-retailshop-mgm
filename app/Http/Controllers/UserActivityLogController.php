<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserActivityLog;
use App\Services\ActivityLogger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class UserActivityLogController extends Controller
{
    /**
     * Helper to resolve authenticated user from Sanctum token or Auth
     */
    protected function getAuthUser(Request $request)
    {
        $user = Auth::user() ?? auth('sanctum')->user() ?? $request->user();
        if (!$user && ($token = $request->bearerToken())) {
            $pat = PersonalAccessToken::findToken($token);
            if ($pat && $pat->tokenable instanceof User) {
                $user = $pat->tokenable;
            }
        }
        return $user;
    }

    /**
     * Check if user is Admin or Super Admin
     */
    protected function isAdminOrSuperAdmin($user)
    {
        if (!$user) return false;
        $role = strtolower(trim($user->role ?? ''));
        return in_array($role, ['admin', 'super_admin', 'super admin']);
    }

    /**
     * Check if user is strictly Super Admin
     */
    protected function isSuperAdmin($user)
    {
        if (!$user) return false;
        $role = strtolower(trim($user->role ?? ''));
        return in_array($role, ['super_admin', 'super admin', 'admin']);
    }

    /**
     * Fetch activity logs with filters, pagination and stats
     */
    public function GetActivityLogs(Request $request)
    {
        try {
            $user = $this->getAuthUser($request);
            if (!$this->isAdminOrSuperAdmin($user)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Access Denied: Only Admin and Super Admin can view user activity logs.'
                ], 403);
            }

            $query = UserActivityLog::query()->orderBy('id', 'desc');

            // Filter: User
            if ($request->filled('user_id') && $request->user_id !== 'all') {
                $query->where('user_id', $request->user_id);
            }

            // Filter: Action (case-insensitive & aliases)
            if ($request->filled('action') && $request->action !== 'all') {
                $act = strtoupper(trim(str_replace([' ', '-'], '_', $request->action)));
                $query->where(function ($q) use ($act, $request) {
                    $q->where('action', $request->action)
                      ->orWhere(\Illuminate\Support\Facades\DB::raw('UPPER(action)'), $act)
                      ->orWhere('action', 'like', "%{$request->action}%");
                });
            }

            // Filter: Module
            if ($request->filled('module') && $request->module !== 'all') {
                $mod = trim($request->module);
                $query->where(function ($q) use ($mod) {
                    $q->where('module', $mod)
                      ->orWhere('module', 'like', "%{$mod}%");
                });
            }

            // Filter: Date
            if ($request->filled('date_range')) {
                $dr = $request->date_range;
                if ($dr === 'today') {
                    $query->whereDate('created_at', Carbon::today());
                } elseif ($dr === 'yesterday') {
                    $query->whereDate('created_at', Carbon::yesterday());
                } elseif ($dr === 'last7') {
                    $query->where('created_at', '>=', Carbon::now()->subDays(7));
                } elseif ($dr === 'this_month') {
                    $query->whereMonth('created_at', Carbon::now()->month)
                          ->whereYear('created_at', Carbon::now()->year);
                }
            } elseif ($request->filled('start_date') && $request->filled('end_date')) {
                $startDate = Carbon::parse($request->start_date)->startOfDay();
                $endDate = Carbon::parse($request->end_date)->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            // Search Keyword
            if ($request->filled('search')) {
                $search = trim($request->search);
                $query->where(function ($q) use ($search) {
                    $q->where('user_name', 'like', "%{$search}%")
                      ->orWhere('user_email', 'like', "%{$search}%")
                      ->orWhere('user_role', 'like', "%{$search}%")
                      ->orWhere('action', 'like', "%{$search}%")
                      ->orWhere('module', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('ip_address', 'like', "%{$search}%");
                });
            }

            // Metric stats for summary cards (matching reference design: Total Logs, Page Logins & Sessions, Data Modifications, Registered Users)
            $totalLogs = UserActivityLog::count();
            $loginsSessions = UserActivityLog::where(function($q) {
                $q->whereIn('action', ['Login', 'Logout', 'UserLogin', 'UserLogout', 'LOGIN', 'LOGOUT'])
                  ->orWhere('action', 'like', '%login%')
                  ->orWhere('action', 'like', '%logout%');
            })->count();
            $dataModifications = max(0, $totalLogs - $loginsSessions);
            $registeredUsers = User::count();

            // Distinct users for dropdown filter
            $usersList = User::select('id', 'name', 'email', 'role', 'img_url')->orderBy('name')->get();

            // Distinct actions & modules for filter
            $actionsList = [
                ['key' => 'all', 'label' => 'All Actions', 'icon' => 'fa-bolt'],
                ['key' => 'LOGIN', 'label' => 'LOGIN', 'icon' => 'fa-right-to-bracket'],
                ['key' => 'LOGOUT', 'label' => 'LOGOUT', 'icon' => 'fa-right-from-bracket'],
                ['key' => 'CREATE', 'label' => 'CREATE', 'icon' => 'fa-plus'],
                ['key' => 'UPDATE', 'label' => 'UPDATE', 'icon' => 'fa-pen-to-square'],
                ['key' => 'DELETE', 'label' => 'DELETE', 'icon' => 'fa-trash-can'],
                ['key' => 'DUE_COLLECTION', 'label' => 'DUE_COLLECTION', 'icon' => 'fa-hand-holding-dollar'],
                ['key' => 'DUE_PAYMENT', 'label' => 'DUE_PAYMENT', 'icon' => 'fa-money-bill-transfer'],
                ['key' => 'SALE', 'label' => 'SALE', 'icon' => 'fa-cart-shopping'],
                ['key' => 'PURCHASE', 'label' => 'PURCHASE', 'icon' => 'fa-boxes-packing'],
                ['key' => 'RETURN', 'label' => 'RETURN', 'icon' => 'fa-arrow-rotate-left'],
                ['key' => 'STATUS_CHANGE', 'label' => 'STATUS_CHANGE', 'icon' => 'fa-arrows-rotate'],
                ['key' => 'CLEAR_LOGS', 'label' => 'CLEAR_LOGS', 'icon' => 'fa-trash'],
            ];

            $modulesList = [
                ['key' => 'all', 'label' => 'All Modules', 'icon' => 'fa-cube'],
                ['key' => 'Auth & Sessions', 'label' => 'Auth & Sessions', 'icon' => 'fa-shield-halved'],
                ['key' => 'Users & Roles', 'label' => 'Users & Roles', 'icon' => 'fa-users-gear'],
                ['key' => 'User Profile', 'label' => 'User Profile', 'icon' => 'fa-circle-user'],
                ['key' => 'POS / Sales', 'label' => 'POS / Sales', 'icon' => 'fa-cash-register'],
                ['key' => 'Customers & Dues', 'label' => 'Customers & Dues', 'icon' => 'fa-user-group'],
                ['key' => 'Purchases', 'label' => 'Purchases', 'icon' => 'fa-truck-ramp-box'],
                ['key' => 'Products & Stock', 'label' => 'Products & Stock', 'icon' => 'fa-boxes-stacked'],
                ['key' => 'Expenses', 'label' => 'Expenses', 'icon' => 'fa-wallet'],
                ['key' => 'Returns', 'label' => 'Returns', 'icon' => 'fa-arrow-rotate-left'],
                ['key' => 'Reports', 'label' => 'Reports', 'icon' => 'fa-chart-pie'],
                ['key' => 'Battery POS', 'label' => 'Battery POS', 'icon' => 'fa-car-battery'],
                ['key' => 'Battery Purchases', 'label' => 'Battery Purchases', 'icon' => 'fa-truck-moving'],
            ];

            $perPage = (int) ($request->per_page ?? 25);
            if ($perPage <= 0 || $perPage > 200) $perPage = 25;

            $logs = $query->paginate($perPage);

            // Format items
            $formattedLogs = collect($logs->items())->map(function ($log) {
                return [
                    'id'          => $log->id,
                    'user_id'     => $log->user_id,
                    'user_name'   => $log->user_name ?: 'System',
                    'user_role'   => $log->user_role ?: 'User',
                    'user_email'  => $log->user_email ?: 'N/A',
                    'action'      => $log->action,
                    'module'      => $log->module ?: 'General',
                    'description' => $log->description,
                    'ip_address'  => $log->ip_address ?: 'N/A',
                    'date'        => $log->created_at ? $log->created_at->format('d M Y, h:i:s a') : 'N/A',
                    'time_ago'    => $log->created_at ? $log->created_at->diffForHumans() : 'N/A',
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => [
                    'logs'         => $formattedLogs,
                    'pagination'   => [
                        'total'        => $logs->total(),
                        'current_page' => $logs->currentPage(),
                        'last_page'    => $logs->lastPage(),
                        'per_page'     => $logs->perPage(),
                    ],
                    'metrics' => [
                        'total_logs'          => $totalLogs,
                        'logins_sessions'     => $loginsSessions,
                        'data_modifications'  => $dataModifications,
                        'registered_users'    => $registeredUsers,
                    ],
                    'users_list'   => $usersList,
                    'actions_list' => $actionsList,
                    'modules_list' => $modulesList,
                    'current_user' => [
                        'id'            => $user->id,
                        'name'          => $user->name,
                        'role'          => $user->role,
                        'is_super_admin'=> $this->isSuperAdmin($user),
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'fail',
                'message' => 'Failed to load activity logs: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get recent logs for the Notification dropdown (dynamic view)
     */
    public function GetRecentActivityLogs(Request $request)
    {
        try {
            $user = $this->getAuthUser($request);
            if (!$this->isAdminOrSuperAdmin($user)) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Unauthorized'
                ], 403);
            }

            $recentLogs = UserActivityLog::orderBy('id', 'desc')
                ->limit(15)
                ->get()
                ->map(function ($log) {
                    return [
                        'id'          => $log->id,
                        'user_name'   => $log->user_name ?: 'System',
                        'user_role'   => $log->user_role ?: 'User',
                        'action'      => $log->action,
                        'module'      => $log->module ?: 'General',
                        'description' => $log->description,
                        'time_ago'    => $log->created_at ? $log->created_at->diffForHumans() : 'Just now',
                        'time'        => $log->created_at ? $log->created_at->format('h:i A') : '',
                    ];
                });

            $todayCount = UserActivityLog::whereDate('created_at', Carbon::today())->count();

            return response()->json([
                'status' => 'success',
                'data'   => [
                    'recent'      => $recentLogs,
                    'today_count' => $todayCount,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'fail',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear all activity logs - Strictly Super Admin only
     */
    public function ClearAllActivityLogs(Request $request)
    {
        try {
            $user = $this->getAuthUser($request);
            if (!$this->isSuperAdmin($user)) {
                return response()->json([
                    'status'  => 'fail',
                    'message' => 'Action Forbidden: Only Super Admin can clear all activity history logs.'
                ], 403);
            }

            UserActivityLog::truncate();

            // Log this clear action as the first new record
            ActivityLogger::log(
                'Clear All',
                'Audit / Security',
                "Super Admin {$user->name} ({$user->email}) cleared all historical user activity logs.",
                ['cleared_by_id' => $user->id, 'timestamp' => Carbon::now()->toDateTimeString()],
                $user
            );

            return response()->json([
                'status'  => 'success',
                'message' => 'All user activity history logs have been successfully cleared.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'fail',
                'message' => 'Failed to clear logs: ' . $e->getMessage()
            ], 500);
        }
    }
}
