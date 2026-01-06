<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityType;
use App\Models\Company;
use App\Models\CompanyType;
use App\Models\Competitor;
use App\Models\Industry;
use App\Models\Lead;
use App\Models\People;
use App\Models\Product;
use App\Models\Source;
use App\Models\Tag;
use App\Models\Territory;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::all();
        $industries = Industry::all();
        $peoples = People::all();
        $companies = Company::all();
        $leads = Lead::all();
        $sources = Source::all();
        $products = Product::all();
        $company_types = CompanyType::all();
        $territories = Territory::all();
        $competitors = Competitor::all();

        $leadtags = Tag::where('tag_id', 1)->get();
        $companytags = Tag::where('tag_id', 2)->get();
        $persontags = Tag::where('tag_id', 3)->get();

        $activity_types = ActivityType::all();

        return view('admin.dashboard', compact(
            'users',
            'company_types',
            'leads',
            'industries',
            'leadtags',
            'companytags',
            'persontags',
            'activity_types',
            'peoples',
            'companies',
            'sources',
            'territories',
            'products',
            'competitors'
        ));
    }
}
