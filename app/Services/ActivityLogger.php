<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;

class ActivityLogger
{
    /**
     * Log user activity safely
     *
     * @param string $action (e.g. 'Login', 'Logout', 'Sale', 'Purchase', 'Create', 'Update', 'Delete', 'Return', 'Payment')
     * @param string $module (e.g. 'Auth', 'POS / Sale', 'Product', 'Purchase', 'Customer', 'Supplier', 'Expense', 'Return', 'Settings')
     * @param string $description Detailed text describing what was done
     * @param mixed $details Optional extra data / array / payload
     * @param User|null $user Optional user instance; if null, will auto-resolve from request
     * @return UserActivityLog|null
     */
    public static function log($action, $module, $description, $details = null, $user = null)
    {
        try {
            $user = self::resolveUser($user);

            $ip = request()->ip();
            $userAgent = request()->userAgent();

            $log = UserActivityLog::create([
                'user_id'     => $user?->id,
                'user_name'   => $user?->name ?? 'System / Guest',
                'user_role'   => $user?->role ?? 'guest',
                'user_email'  => $user?->email,
                'action'      => $action,
                'module'      => $module,
                'description' => $description,
                'details'     => is_array($details) || is_object($details) ? json_encode($details) : $details,
                'ip_address'  => $ip,
                'user_agent'  => $userAgent,
            ]);

            return $log;
        } catch (\Throwable $e) {
            // Never allow logging error to interrupt the main business logic
            Log::error('ActivityLogger failed: ' . $e->getMessage(), [
                'action' => $action,
                'module' => $module,
            ]);
            return null;
        }
    }

    /**
     * Resolve current user from Auth, Sanctum token, or session
     */
    protected static function resolveUser($user = null)
    {
        if ($user instanceof User) {
            return $user;
        }

        // 1. Direct Auth check
        if (Auth::check()) {
            return Auth::user();
        }

        // 2. Sanctum guard check
        if (auth('sanctum')->check()) {
            return auth('sanctum')->user();
        }

        // 3. Request user
        if (request()->user()) {
            return request()->user();
        }

        // 4. Resolve from Bearer token if present
        $bearerToken = request()->bearerToken();
        if ($bearerToken) {
            $pat = PersonalAccessToken::findToken($bearerToken);
            if ($pat && $pat->tokenable instanceof User) {
                return $pat->tokenable;
            }
        }

        return null;
    }
}
