<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\People;
use Carbon\Carbon;

class SaleController extends Controller
{
    // Calculate percent difference
    private function calculatePercentChange($current, $previous)
    {
        if ($previous == 0) {
            return 0;
        }

        return (int) round(abs(($current - $previous) / $previous * 100));
    }

    // Format sentence for change
    private function formatChangeSentence($current, $previous)
    {
        $diff = $current - $previous;
        $percent = $this->calculatePercentChange($current, $previous);
        if ($diff >= 0) {
            return "Up {$percent}% From {$previous} This Time Last Month";
        } else {
            return "Down {$percent}% From {$previous} This Time Last Month";
        }
    }

    public function index()
    {
        $leads = Lead::with('assignee', 'companies', 'products', 'peoples', 'sources', 'competitors')->get();
        $peoples = People::with('peopleEmail', 'peoplePhone', 'peopleAddress', 'peopleUrl', 'peopleTask', 'peopleCompany')->get();

        $today = Carbon::now();
        $startOfThisMonth = $today->copy()->startOfMonth();
        $endOfToday = $today->copy()->endOfDay();
        $startOfLastMonth = $today->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $today->copy()->subMonth()->endOfMonth();

        // New Leads
        $newLeadsThisMonth = Lead::whereBetween('created_at', [$startOfThisMonth, $endOfToday])->count();
        $newLeadsLastMonth = Lead::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $newLeadsDiff = $newLeadsThisMonth - $newLeadsLastMonth;
        $newLeadsPercent = $this->calculatePercentChange($newLeadsThisMonth, $newLeadsLastMonth);
        $newLeadsChange = $this->formatChangeSentence($newLeadsThisMonth, $newLeadsLastMonth);

        // Open Leads
        $openLeadsThisMonth = Lead::where('lead_status', 'open')->whereBetween('created_at', [$startOfThisMonth, $endOfToday])->count();
        $openLeadsLastMonth = Lead::where('lead_status', 'open')->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $openLeadsDiff = $openLeadsThisMonth - $openLeadsLastMonth;
        $openLeadsPercent = $this->calculatePercentChange($openLeadsThisMonth, $openLeadsLastMonth);
        $openLeadsChange = $this->formatChangeSentence($openLeadsThisMonth, $openLeadsLastMonth);

        // Sales (Won Leads)
        $salesLeadsThisMonth = Lead::where('lead_status', 'won')->whereBetween('close_date', [$startOfThisMonth, $endOfToday])->count();
        $salesLeadsLastMonth = Lead::where('lead_status', 'won')->whereBetween('close_date', [$startOfLastMonth, $endOfLastMonth])->count();
        $salesLeadsDiff = $salesLeadsThisMonth - $salesLeadsLastMonth;
        $salesLeadsPercent = $this->calculatePercentChange($salesLeadsThisMonth, $salesLeadsLastMonth);
        $salesLeadsChange = $this->formatChangeSentence($salesLeadsThisMonth, $salesLeadsLastMonth);

        // Section 2: Lead Summary
        $startOfWeek = $today->copy()->startOfWeek();
        $endOfWeek = $today->copy()->endOfWeek();

        $allLeads = Lead::all();
        $allLeadsCount = $allLeads->count();
        $allLeadsValue = Helper::calculateTotalValue($allLeads);
        $allLeadsValueFormatted = Helper::formatValue($allLeadsValue);

        $myLeads = Lead::where('assignee_id', auth()->id())->get();
        $myLeadsCount = $myLeads->count();
        $myLeadsValue = Helper::calculateTotalValue($myLeads);
        $myLeadsValueFormatted = Helper::formatValue($myLeadsValue);

        $addedThisWeek = Lead::whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();
        $addedThisWeekCount = $addedThisWeek->count();
        $addedThisWeekValue = Helper::calculateTotalValue($addedThisWeek);
        $addedThisWeekValueFormatted = Helper::formatValue($addedThisWeekValue);

        $closingThisWeek = Lead::whereBetween('close_date', [$startOfWeek, $endOfWeek])->get();
        $closingThisWeekCount = $closingThisWeek->count();
        $closingThisWeekValue = Helper::calculateTotalValue($closingThisWeek);
        $closingThisWeekValueFormatted = Helper::formatValue($closingThisWeekValue);

        $hotLeads = Lead::whereJsonContains('lead_flags', 'hot')->get();
        $hotLeadsCount = $hotLeads->count();
        $hotLeadsValue = Helper::calculateTotalValue($hotLeads);
        $hotLeadsValueFormatted = Helper::formatValue($hotLeadsValue);

        // Section 3: Pipeline
        $gbPresentation = Lead::where('stage_id', 1)->get();
        $gbPresentationCount = $gbPresentation->count();
        $gbPresentationCountValue = Helper::calculateTotalValue($gbPresentation);
        $gbPresentationCountValueFormatted = Helper::formatValue($gbPresentationCountValue);

        $siteSurvey = Lead::where('stage_id', 2)->get();
        $siteSurveyCount = $siteSurvey->count();
        $siteSurveyCountValue = Helper::calculateTotalValue($siteSurvey);
        $siteSurveyCountValueFormatted = Helper::formatValue($siteSurveyCountValue);

        $proposalApproval = Lead::where('stage_id', 3)->get();
        $proposalApprovalCount = $proposalApproval->count();
        $proposalApprovalCountValue = Helper::calculateTotalValue($proposalApproval);
        $proposalApprovalCountValueFormatted = Helper::formatValue($proposalApprovalCountValue);

        $proposalPresentation = Lead::where('stage_id', 4)->get();
        $proposalPresentationCount = $proposalPresentation->count();
        $proposalPresentationCountValue = Helper::calculateTotalValue($proposalPresentation);
        $proposalPresentationCountValueFormatted = Helper::formatValue($proposalPresentationCountValue);

        $signedProposal = Lead::where('stage_id', 5)->get();
        $signedProposalCount = $signedProposal->count();
        $signedProposalCountValue = Helper::calculateTotalValue($signedProposal);
        $signedProposalCountValueFormatted = Helper::formatValue($signedProposalCountValue);

        return view('admin.sales', compact('leads', 'peoples',
            'newLeadsThisMonth', 'newLeadsLastMonth', 'newLeadsDiff', 'newLeadsPercent',
            'openLeadsThisMonth', 'openLeadsLastMonth', 'openLeadsDiff', 'openLeadsPercent',
            'salesLeadsThisMonth', 'salesLeadsLastMonth', 'salesLeadsDiff', 'salesLeadsPercent',
            'newLeadsChange', 'openLeadsChange', 'salesLeadsChange',
            'allLeadsCount', 'myLeadsCount', 'addedThisWeekCount', 'closingThisWeekCount', 'hotLeadsCount',
            'allLeadsValue', 'myLeadsValue', 'addedThisWeekValue', 'closingThisWeekValue', 'hotLeadsValue',
            'allLeadsValueFormatted', 'myLeadsValueFormatted', 'addedThisWeekValueFormatted', 'closingThisWeekValueFormatted', 'hotLeadsValueFormatted',
            'gbPresentationCount', 'siteSurveyCount', 'proposalApprovalCount', 'proposalPresentationCount', 'signedProposalCount',
            'gbPresentationCountValueFormatted', 'siteSurveyCountValueFormatted', 'proposalApprovalCountValueFormatted', 'proposalPresentationCountValueFormatted', 'signedProposalCountValueFormatted',
        ));

    }
}
