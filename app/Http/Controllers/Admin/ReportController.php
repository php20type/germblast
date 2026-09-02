<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display the New Leads report.
     */
    public function newLeads(Request $request)
    {
        $period = $request->query('period', 'week');
        $offset = (int) $request->query('offset', 0);

        // Calculate date window based on selected period and offset
        switch ($period) {
            case 'day':
                $startDate = Carbon::now()->addDays($offset)->startOfDay();
                $endDate = (clone $startDate)->endOfDay();
                $groupBy = 'hour';
                break;
            case 'week':
                $startDate = Carbon::now()->addWeeks($offset)->startOfWeek();
                $endDate = (clone $startDate)->endOfWeek();
                $groupBy = 'day';
                break;
            case 'month':
                $startDate = Carbon::now()->addMonths($offset)->startOfMonth();
                $endDate = (clone $startDate)->endOfMonth();
                $groupBy = 'day';
                break;
            case 'quarter':
                $startDate = Carbon::now()->addQuarters($offset)->startOfQuarter();
                $endDate = (clone $startDate)->endOfQuarter();
                $groupBy = 'week';
                break;
            case 'year':
            default:
                $period = 'year';
                $startDate = Carbon::now()->addYears($offset)->startOfYear();
                $endDate = (clone $startDate)->endOfYear();
                $groupBy = 'month';
                break;
        }

        // Retrieve leads in the date range with products for value calculation
        $leads = Lead::with('products')->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get();

        $paginatedLeads = Lead::with(['products', 'assignee', 'stages', 'sources', 'company'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        $groupedLeads = app(\App\Http\Controllers\Admin\LeadController::class)->groupLeads($paginatedLeads->getCollection());

        // 1. Calculate KPI: Total Value using Helper to match All Leads
        $totalValue = \App\Helpers\Helper::calculateTotalValue($leads);

        // 2. Calculate KPI: Avg Value per week
        $weeks = $startDate->diffInWeeks($endDate) ?: 1;
        $avgValuePerWeek = $totalValue / $weeks;

        // 3. Calculate KPI: Avg time open (days)
        $totalTimeOpen = 0;
        $openLeadsCount = 0;
        foreach ($leads as $lead) {
            // If lead has a close_date, use that, else use now()
            $end = $lead->close_date ? Carbon::parse($lead->close_date) : Carbon::now();
            $start = Carbon::parse($lead->created_at);
            // Ensure absolute difference
            $totalTimeOpen += abs($start->diffInDays($end, false));
            $openLeadsCount++;
        }
        $avgTimeOpen = $openLeadsCount > 0 ? $totalTimeOpen / $openLeadsCount : 0;

        // 4. Calculate KPI: Avg lead value
        $avgLeadValue = $leads->count() > 0 ? $totalValue / $leads->count() : 0;

        // 5. Format Data for Chart (grouped dynamically)
        $chartData = [];
        $tableData = [];
        
        $leads->groupBy(function($date) use ($groupBy) {
            $cDate = Carbon::parse($date->created_at);
            switch ($groupBy) {
                case 'hour':
                    return $cDate->format('g A');
                case 'day':
                    return $cDate->format('M j, Y');
                case 'week':
                    return 'Week of ' . $cDate->startOfWeek()->format('M j');
                case 'month':
                    return $cDate->format('M Y');
            }
        })->each(function($group, $key) use (&$chartData, &$tableData) {
            // Use Helper for proper sum
            $sum = \App\Helpers\Helper::calculateTotalValue($group);
            $count = $group->count();
            
            $chartData['labels'][] = $key;
            $chartData['values'][] = $sum;
            $chartData['quantities'][] = $count;
            
            $tableData[] = [
                'date' => $key,
                'value' => $sum,
                'quantity' => $count
            ];
        });

        // Ensure tableData is sorted newest first or oldest first based on preference (usually oldest first for charts, newest first for table)
        // Table data will be displayed in blade.
        return view('admin.reports.new-leads', compact(
            'leads', 
            'totalValue', 
            'avgValuePerWeek', 
            'avgTimeOpen', 
            'avgLeadValue', 
            'chartData',
            'tableData',
            'startDate',
            'endDate',
            'offset',
            'period',
            'paginatedLeads',
            'groupedLeads'
        ));
    }

    public function sales(Request $request)
    {
        $period = $request->query('period', 'week');
        $offset = (int) $request->query('offset', 0);

        // Calculate date window based on selected period and offset
        switch ($period) {
            case 'day':
                $startDate = Carbon::now()->addDays($offset)->startOfDay();
                $endDate = (clone $startDate)->endOfDay();
                $groupBy = 'hour';
                break;
            case 'week':
                $startDate = Carbon::now()->addWeeks($offset)->startOfWeek();
                $endDate = (clone $startDate)->endOfWeek();
                $groupBy = 'day';
                break;
            case 'month':
                $startDate = Carbon::now()->addMonths($offset)->startOfMonth();
                $endDate = (clone $startDate)->endOfMonth();
                $groupBy = 'day';
                break;
            case 'quarter':
                $startDate = Carbon::now()->addQuarters($offset)->startOfQuarter();
                $endDate = (clone $startDate)->endOfQuarter();
                $groupBy = 'week';
                break;
            case 'year':
            default:
                $period = 'year';
                $startDate = Carbon::now()->addYears($offset)->startOfYear();
                $endDate = (clone $startDate)->endOfYear();
                $groupBy = 'month';
                break;
        }

        // Retrieve leads in the date range with products for value calculation
        $leads = Lead::with('products')->where('lead_status', 'won')->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get();

        $paginatedLeads = Lead::with(['products', 'assignee', 'stages', 'sources', 'company'])
            ->where('lead_status', 'won')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        $groupedLeads = app(\App\Http\Controllers\Admin\LeadController::class)->groupLeads($paginatedLeads->getCollection());

        // 1. Calculate KPI: Total Value using Helper to match All Leads
        $totalValue = \App\Helpers\Helper::calculateTotalValue($leads);

        // 2. Calculate KPI: Avg Value per week
        $weeks = $startDate->diffInWeeks($endDate) ?: 1;
        $avgValuePerWeek = $totalValue / $weeks;

        // 3. Calculate KPI: Avg time open (days)
        $totalTimeOpen = 0;
        $openLeadsCount = 0;
        foreach ($leads as $lead) {
            // If lead has a close_date, use that, else use now()
            $end = $lead->close_date ? Carbon::parse($lead->close_date) : Carbon::now();
            $start = Carbon::parse($lead->created_at);
            // Ensure absolute difference
            $totalTimeOpen += abs($start->diffInDays($end, false));
            $openLeadsCount++;
        }
        $avgTimeOpen = $openLeadsCount > 0 ? $totalTimeOpen / $openLeadsCount : 0;

        // 4. Calculate KPI: Avg lead value
        $avgLeadValue = $leads->count() > 0 ? $totalValue / $leads->count() : 0;

        // Prepare chart and table data
        $chartData = [];
        $tableData = [];
        
        $leads->groupBy(function($date) use ($groupBy) {
            $cDate = Carbon::parse($date->created_at);
            switch ($groupBy) {
                case 'hour':
                    return $cDate->format('g A');
                case 'day':
                    return $cDate->format('M j, Y');
                case 'week':
                    return 'Week of ' . $cDate->startOfWeek()->format('M j');
                case 'month':
                    return $cDate->format('M Y');
            }
        })->each(function($group, $key) use (&$chartData, &$tableData) {
            // Use Helper for proper sum
            $sum = \App\Helpers\Helper::calculateTotalValue($group);
            $count = $group->count();
            
            $chartData['labels'][] = $key;
            $chartData['values'][] = $sum;
            $chartData['quantities'][] = $count;
            
            $tableData[] = [
                'date' => $key,
                'count' => $count,
                'value' => $sum,
            ];
        });

        return view('admin.reports.sales', compact(
            'leads', 
            'totalValue', 
            'avgValuePerWeek', 
            'avgTimeOpen', 
            'avgLeadValue',
            'chartData',
            'tableData',
            'startDate',
            'endDate',
            'offset',
            'period',
            'paginatedLeads',
            'groupedLeads'
        ));
    }

    public function lostLeads(Request $request)
    {
        $period = $request->query('period', 'week');
        $offset = (int) $request->query('offset', 0);

        // Calculate date window based on selected period and offset
        switch ($period) {
            case 'day':
                $startDate = Carbon::now()->addDays($offset)->startOfDay();
                $endDate = (clone $startDate)->endOfDay();
                $groupBy = 'hour';
                break;
            case 'week':
                $startDate = Carbon::now()->addWeeks($offset)->startOfWeek();
                $endDate = (clone $startDate)->endOfWeek();
                $groupBy = 'day';
                break;
            case 'month':
                $startDate = Carbon::now()->addMonths($offset)->startOfMonth();
                $endDate = (clone $startDate)->endOfMonth();
                $groupBy = 'day';
                break;
            case 'quarter':
                $startDate = Carbon::now()->addQuarters($offset)->startOfQuarter();
                $endDate = (clone $startDate)->endOfQuarter();
                $groupBy = 'week';
                break;
            case 'year':
            default:
                $period = 'year';
                $startDate = Carbon::now()->addYears($offset)->startOfYear();
                $endDate = (clone $startDate)->endOfYear();
                $groupBy = 'month';
                break;
        }

        // Retrieve leads in the date range with products for value calculation
        $leads = Lead::with('products')->where('lead_status', 'lost')->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get();

        $paginatedLeads = Lead::with(['products', 'assignee', 'stages', 'sources', 'company'])
            ->where('lead_status', 'lost')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        $groupedLeads = app(\App\Http\Controllers\Admin\LeadController::class)->groupLeads($paginatedLeads->getCollection());

        // 1. Calculate KPI: Total Value using Helper to match All Leads
        $totalValue = \App\Helpers\Helper::calculateTotalValue($leads);

        // 2. Calculate KPI: Avg Value per week
        $weeks = $startDate->diffInWeeks($endDate) ?: 1;
        $avgValuePerWeek = $totalValue / $weeks;

        // 3. Calculate KPI: Avg time open (days)
        $totalTimeOpen = 0;
        $openLeadsCount = 0;
        foreach ($leads as $lead) {
            // If lead has a close_date, use that, else use now()
            $end = $lead->close_date ? Carbon::parse($lead->close_date) : Carbon::now();
            $start = Carbon::parse($lead->created_at);
            // Ensure absolute difference
            $totalTimeOpen += abs($start->diffInDays($end, false));
            $openLeadsCount++;
        }
        $avgTimeOpen = $openLeadsCount > 0 ? $totalTimeOpen / $openLeadsCount : 0;

        // 4. Calculate KPI: Avg lead value
        $avgLeadValue = $leads->count() > 0 ? $totalValue / $leads->count() : 0;

        // Prepare chart and table data
        $chartData = [];
        $tableData = [];
        
        $leads->groupBy(function($date) use ($groupBy) {
            $cDate = Carbon::parse($date->created_at);
            switch ($groupBy) {
                case 'hour':
                    return $cDate->format('g A');
                case 'day':
                    return $cDate->format('M j, Y');
                case 'week':
                    return 'Week of ' . $cDate->startOfWeek()->format('M j');
                case 'month':
                    return $cDate->format('M Y');
            }
        })->each(function($group, $key) use (&$chartData, &$tableData) {
            // Use Helper for proper sum
            $sum = \App\Helpers\Helper::calculateTotalValue($group);
            $count = $group->count();
            
            $chartData['labels'][] = $key;
            $chartData['values'][] = $sum;
            $chartData['quantities'][] = $count;
            
            $tableData[] = [
                'date' => $key,
                'count' => $count,
                'value' => $sum,
            ];
        });

        return view('admin.reports.losses-leads', compact(
            'leads', 
            'totalValue', 
            'avgValuePerWeek', 
            'avgTimeOpen', 
            'avgLeadValue',
            'chartData',
            'tableData',
            'startDate',
            'endDate',
            'offset',
            'period',
            'paginatedLeads',
            'groupedLeads'
        ));
    }

    public function products(Request $request)
    {
        $period = $request->query('period', 'year');
        $offset = (int) $request->query('offset', 0);
        $sort = $request->query('sort', 'revenue'); // 'revenue' or 'quantity'
        $status = $request->query('status', 'won');

        // Calculate date window based on selected period and offset
        switch ($period) {
            case 'day':
                $startDate = Carbon::now()->addDays($offset)->startOfDay();
                $endDate = (clone $startDate)->endOfDay();
                break;
            case 'week':
                $startDate = Carbon::now()->addWeeks($offset)->startOfWeek();
                $endDate = (clone $startDate)->endOfWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->addMonths($offset)->startOfMonth();
                $endDate = (clone $startDate)->endOfMonth();
                break;
            case 'quarter':
                $startDate = Carbon::now()->addQuarters($offset)->startOfQuarter();
                $endDate = (clone $startDate)->endOfQuarter();
                break;
            case 'year':
            default:
                $period = 'year';
                $startDate = Carbon::now()->addYears($offset)->startOfYear();
                $endDate = (clone $startDate)->endOfYear();
                break;
        }

        // Retrieve leads in the date range with products
        $leads = Lead::with('products')
            ->where('lead_status', $status)
            ->whereNotNull('close_date')
            ->whereBetween('close_date', [$startDate, $endDate])
            ->get();

        $allProducts = \App\Models\Product::all();
        $productStats = [];
        foreach ($allProducts as $p) {
            $productStats[$p->id] = [
                'id' => $p->id,
                'name' => $p->name,
                'category' => $p->product_type ?? '-',
                'sku' => $p->sku ?? '-',
                'revenue' => 0,
                'quantity' => 0,
                'leads' => [],
            ];
        }

        $totalQuantity = 0;
        $totalValue = 0;
        $allLeadsIds = [];

        foreach ($leads as $lead) {
            foreach ($lead->products as $product) {
                if (!isset($productStats[$product->id])) {
                    $productStats[$product->id] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'category' => $product->product_type ?? '-',
                        'sku' => $product->sku ?? '-',
                        'revenue' => 0,
                        'quantity' => 0,
                        'leads' => [],
                    ];
                }
                
                $qty = $product->pivot->qty ?? 1;
                $price = $product->pivot->price ?? $product->price ?? 0;
                $revenue = $qty * $price;
                
                $productStats[$product->id]['revenue'] += $revenue;
                $productStats[$product->id]['quantity'] += $qty;
                $productStats[$product->id]['leads'][$lead->id] = true;
                
                $totalQuantity += $qty;
                $totalValue += $revenue;
                $allLeadsIds[$lead->id] = true;
            }
        }
        
        $uniqueProductsCount = count($productStats);
        $totalLeadsCount = count($allLeadsIds);
        
        foreach ($productStats as &$stat) {
            $stat['leads_count'] = count($stat['leads']);
            unset($stat['leads']); // free up memory
        }
        
        $productStatsCollection = collect($productStats)->sortByDesc($sort);

        // Chart Data (Top 5 + Other)
        $topProducts = $productStatsCollection->take(5);
        $otherProducts = $productStatsCollection->slice(5);
        
        $chartData = [
            'top' => array_values($topProducts->toArray()),
            'other' => [
                'count' => $otherProducts->count(),
                'revenue' => $otherProducts->sum('revenue'),
                'quantity' => $otherProducts->sum('quantity'),
            ]
        ];

        // Manual Pagination for array
        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $perPage = 20;
        $paginatedProducts = new \Illuminate\Pagination\LengthAwarePaginator(
            $productStatsCollection->forPage($page, $perPage),
            $productStatsCollection->count(),
            $perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        if ($request->ajax()) {
            return view('admin.reports.partials.products_list', compact(
                'paginatedProducts',
                'chartData',
                'totalQuantity',
                'totalValue',
                'uniqueProductsCount',
                'totalLeadsCount',
                'startDate',
                'endDate',
                'offset',
                'period',
                'sort',
                'status'
            ))->render();
        }

        return view('admin.reports.products', compact(
            'paginatedProducts',
            'chartData',
            'totalQuantity',
            'totalValue',
            'uniqueProductsCount',
            'totalLeadsCount',
            'startDate',
            'endDate',
            'offset',
            'period',
            'sort',
            'status'
        ));
    }
}
