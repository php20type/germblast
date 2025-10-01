<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\People;
use Carbon\Carbon;

class SaleController extends Controller
{
    public function index()
    {
        $leads = Lead::with('assignee', 'companies', 'products', 'peoples', 'sources', 'competitors')->get();
        $peoples = People::with('peopleEmail', 'peoplePhone', 'peopleAddress', 'peopleUrl', 'peopleTask', 'peopleCompany')->get();

        // Section 1
        $startOfThisMonth = Carbon::now()->startOfMonth();
        $endOfToday = Carbon::now()->endOfDay();

        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        $newLeadsThisMonth = Lead::whereBetween('created_at', [$startOfThisMonth, $endOfToday])->count();
        $newLeadsLastMonth = Lead::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $newLeadsDiff = $newLeadsThisMonth - $newLeadsLastMonth;
        $newLeadsPercent = $newLeadsLastMonth == 0 ? 0 : ($newLeadsDiff / $newLeadsLastMonth) * 100;

        // $openLeads = Lead::where('lead_status', 'open')->count();
        $openLeadsThisMonth = Lead::where('lead_status', 'open')->whereBetween('created_at', [$startOfThisMonth, $endOfToday])->count();
        $openLeadsLastMonth = Lead::where('lead_status', 'open')->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $openLeadsDiff = $openLeadsThisMonth - $openLeadsLastMonth;
        $openLeadsPercent = $openLeadsLastMonth == 0 ? 0 : ($openLeadsDiff / $openLeadsLastMonth) * 100;

        // $salesLeads = Lead::whereBetween('close_date', [$startOfThisMonth, $endOfToday])->where('lead_status', 'won')->count();
        $salesLeadsThisMonth = Lead::where('lead_status', 'won')->whereBetween('close_date', [$startOfThisMonth, $endOfToday])->count();
        $salesLeadsLastMonth = Lead::where('lead_status', 'won')->whereBetween('close_date', [$startOfLastMonth, $endOfLastMonth])->count();
        $salesLeadsDiff = $salesLeadsThisMonth - $salesLeadsLastMonth;
        $salesLeadsPercent = $salesLeadsLastMonth == 0 ? 0 : ($salesLeadsDiff / $salesLeadsLastMonth) * 100;

        // Section 2
        $now = Carbon::now();
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();

        $addedThisWeekCount = Lead::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $closingThisWeekCount = Lead::whereBetween('close_date', [$startOfWeek, $endOfWeek])->count();

        return view('admin.sales', compact('newLeadsThisMonth', 'newLeadsDiff', 'newLeadsPercent',
        'openLeadsThisMonth', 'openLeadsDiff', 'openLeadsPercent',
        'salesLeadsThisMonth', 'salesLeadsDiff', 'salesLeadsPercent'));
    }
}
