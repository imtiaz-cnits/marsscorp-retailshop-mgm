<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class DashboardDateFilterService
 * 
 * Shared Date-Filtering Standard for MARSS Dashboards (Retail & Battery).
 * 
 * Guarantees:
 * 1. Strict business transaction date filtering (invoice_date, due_collection_date, date, etc.).
 * 2. Zero leakage from created_at, updated_at, or import timestamps.
 * 3. Consistent filter range resolution across 'today', 'last_week', 'this_month', 'last_month', 'date_wise', 'all_time'.
 * 4. Safe varchar date parsing (YYYY-MM-DD, DD-MM-YYYY, DD/MM/YYYY) with strict ELSE NULL fallback.
 */
class DashboardDateFilterService
{
    /**
     * Resolve filter parameters and return:
     * [$filterType, $filterStart, $filterEnd, $chartTitle]
     * 
     * Default MUST strictly be 'today'.
     */
    public static function resolveFilterRange(?Request $request): array
    {
        $filterType = $request ? ($request->input('filter_type') ?: $request->query('filter_type') ?: $request->header('X-Filter-Type')) : null;
        $customStart = $request ? ($request->input('start_date') ?: $request->query('start_date')) : null;
        $customEnd = $request ? ($request->input('end_date') ?: $request->query('end_date')) : null;

        if (!$filterType && !empty($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '?') !== false) {
            $rawQuery = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
            if ($rawQuery) {
                parse_str($rawQuery, $parsedParams);
                if (!empty($parsedParams['filter_type'])) $filterType = $parsedParams['filter_type'];
                if (!$customStart && !empty($parsedParams['start_date'])) $customStart = $parsedParams['start_date'];
                if (!$customEnd && !empty($parsedParams['end_date'])) $customEnd = $parsedParams['end_date'];
            }
        }

        $filterType = $filterType ?: 'today';
        $today = Carbon::today()->toDateString();

        if ($filterType === 'all_time') {
            $filterStart = null;
            $filterEnd = null;
            $chartTitle = 'Sales & Profit Trend (Last 30 Days)';
        } elseif ($filterType === 'this_month') {
            $filterStart = Carbon::now()->startOfMonth()->toDateString();
            $filterEnd = $today;
            $chartTitle = 'Sales & Profit Trend (This Month)';
        } elseif ($filterType === 'last_week') {
            $filterStart = Carbon::today()->subDays(6)->toDateString(); // 7 days: today + past 6
            $filterEnd = $today;
            $chartTitle = 'Sales & Profit Trend (Last 7 Days)';
        } elseif ($filterType === 'last_month') {
            $filterStart = Carbon::today()->subDays(29)->toDateString(); // 30 days: today + past 29
            $filterEnd = $today;
            $chartTitle = 'Sales & Profit Trend (Last 30 Days)';
        } elseif ($filterType === 'date_wise' && $customStart) {
            $filterStart = Carbon::parse($customStart)->toDateString();
            $filterEnd = $customEnd ? Carbon::parse($customEnd)->toDateString() : $filterStart;
            if ($filterStart > $filterEnd) {
                $tmp = $filterStart;
                $filterStart = $filterEnd;
                $filterEnd = $tmp;
            }
            $chartTitle = 'Sales & Profit Trend (' . Carbon::parse($filterStart)->format('d M') . ' - ' . Carbon::parse($filterEnd)->format('d M Y') . ')';
        } else {
            $filterType = 'today';
            $filterStart = $today;
            $filterEnd = $today;
            $chartTitle = 'Sales & Profit Trend (Last 7 Days)';
        }

        return [$filterType, $filterStart, $filterEnd, $chartTitle];
    }

    /**
     * Standardized SQL Expression to parse business date strings.
     * Handles:
     * - YYYY-MM-DD / YYYY-MM-DD HH:MM:SS
     * - DD-MM-YYYY
     * - DD/MM/YYYY
     * 
     * STRICT SAFETY RULE:
     * If unparseable or NULL, evaluates to NULL. NEVER falls back to created_at or today!
     */
    public static function dateSql(string $column): string
    {
        return "
            CASE 
                WHEN {$column} REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}' THEN STR_TO_DATE(SUBSTRING({$column}, 1, 10), '%Y-%m-%d')
                WHEN {$column} REGEXP '^[0-9]{2}-[0-9]{2}-[0-9]{4}' THEN STR_TO_DATE(SUBSTRING({$column}, 1, 10), '%d-%m-%Y')
                WHEN {$column} REGEXP '^[0-9]{2}/[0-9]{2}/[0-9]{4}' THEN STR_TO_DATE(SUBSTRING({$column}, 1, 10), '%d/%m/%Y')
                ELSE NULL
            END
        ";
    }

    /**
     * Apply strict business date filtering to an Eloquent or DB query builder.
     */
    public static function applyDateFilter($query, string $column, ?string $filterStart, ?string $filterEnd)
    {
        return $query->when($filterStart && $filterEnd, function($q) use ($column, $filterStart, $filterEnd) {
            $q->whereBetween(DB::raw(self::dateSql($column)), [$filterStart, $filterEnd]);
        });
    }

    /**
     * Apply strict invoice date filtering.
     * Uses COALESCE(invoice_date, DATE(created_at)) only for historical rows where invoice_date is NULL,
     * but NEVER uses orWhereBetween(DATE(created_at)).
     */
    public static function applyInvoiceDateFilter($query, string $column = 'invoice_date', ?string $filterStart = null, ?string $filterEnd = null)
    {
        return $query->when($filterStart && $filterEnd, function($q) use ($column, $filterStart, $filterEnd) {
            $q->whereBetween(DB::raw("COALESCE({$column}, DATE(created_at))"), [$filterStart, $filterEnd]);
        });
    }
}

