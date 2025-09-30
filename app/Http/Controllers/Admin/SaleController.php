<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\People;
use Carbon\Carbon;

class SaleController extends Controller
{
    public function index()
    {
        $leads = Lead::with('assignee', 'companies', 'products', 'peoples', 'sources', 'competitors')->get();
        $peoples = People::with('')->get();

        // Get current week's Monday and Sunday
        // Section 1
        $startOfMonth = Carbon::now()->startOfMonth(); // Monday
        $today = Carbon::now()->endOfDay();

        $newLeads = Lead::whereBetween('created_at', [$startOfMonth, $today]);
        $openLeads = Lead::where('lead_status', 'open')->get();
        $salesLeads = Lead::whereBetween('close_date', [$startOfMonth, $today])
            ->where('lead_status', 'won')
            ->get();

        $openLeadsCount = $openLeads->count();
        $newLeadsCount = $newLeads->count();
        $salesLeadsCount = $salesLeads->count();

        // Section 2
        $now = Carbon::now();
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();

        $addedThisWeekCount = Lead::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $closingThisWeekCount = Lead::whereBetween('close_date', [$startOfWeek, $endOfWeek])->count();

        return view('admin.sales', compact('openLeadsCount', 'newLeadsCount', 'salesLeadsCount'));
    }

}
