<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityType;
use App\Models\Channel;
use App\Models\CompanyType;
use App\Models\Competitor;
use App\Models\Currency;
use App\Models\Industry;
use App\Models\Market;
use App\Models\Product;
use App\Models\Source;
use App\Models\Tag;
use App\Models\Territory;
use App\Models\TerritoryLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {

        return redirect()->route('admin.settings.activity_type');

    }

    public function activity_type()
    {
        $icons = [
            'fas fa-phone',
            'fas fa-calendar',
            'fas fa-users',
            'fas fa-pencil',
            'fas fa-envelope',
            'fas fa-briefcase',
            'fas fa-comments',
            'fas fa-globe',
            'fas fa-chart-line',
            'fas fa-user',
            'fas fa-building',
            'fas fa-map-marker-alt',
            'fas fa-file-alt',
            'fas fa-bullhorn',
            'fas fa-handshake',
            'fas fa-credit-card',
        ];

        $activity_types = ActivityType::all();
        $totalCounts = ActivityType::count();

        $activityCounts = Activity::select('activity_type_id', DB::raw('count(*) as total'))
            ->groupBy('activity_type_id')
            ->pluck('total', 'activity_type_id');

        return view('admin.settings.activity_type', compact('activity_types', 'activityCounts', 'totalCounts', 'icons'));

    }

    public function activity_type_store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required',
            'icon' => 'required',
        ]);

        $data = [
            'type' => $validated['name'],
            'icon' => $validated['icon'],
        ];

        $activity_type = ActivityType::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Activity type added successfully.',
                'company' => $activity_type,
            ]);
        }

        return redirect()->back()->with('success', 'Activity type added successfully.');
    }

    public function activity_type_update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'icon' => 'required',
        ]);

        $activity_type = ActivityType::findOrFail($id);
        $activity_type->update([
            'type' => $validated['name'],
            'icon' => $validated['icon'],
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Activity type updated successfully.',
                'company' => $activity_type,
            ]);
        }

        return redirect()->back()->with('success', 'Activity type updated successfully.');
    }

    public function competitor()
    {

        $competitors = Competitor::all();
        $totalCounts = Competitor::count();

        return view('admin.settings.competitors', compact('competitors', 'totalCounts'));

    }

    public function competitor_store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required',
        ]);

        $data = [
            'name' => $validated['name'],
        ];

        $competitor = Competitor::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Competitor added successfully.',
                'company' => $competitor,
            ]);
        }

        return redirect()->back()->with('success', 'Competitor added successfully.');

    }

    public function competitor_update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $competitor = Competitor::findOrFail($id);
        $competitor->update([
            'name' => $validated['name'],
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Competitor updated successfully.',
                'company' => $competitor,
            ]);
        }

        return redirect()->back()->with('success', 'Competitor updated successfully.');
    }

    public function industry()
    {

        $industries = Industry::all();
        $totalCounts = Industry::count();

        return view('admin.settings.industries', compact('industries', 'totalCounts'));

    }

    public function industry_store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required',
        ]);

        $data = [
            'name' => $validated['name'],
        ];

        $industry = Industry::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Industry added successfully.',
                'company' => $industry,
            ]);
        }

        return redirect()->back()->with('success', 'Industry added successfully.');

    }

    public function industry_update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $industry = Industry::findOrFail($id);
        $industry->update([
            'name' => $validated['name'],
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Industry updated successfully.',
                'company' => $industry,
            ]);
        }

        return redirect()->back()->with('success', 'Industry updated successfully.');
    }

    public function channel_source()
    {
        $all_channels = Channel::all();
        // Sources with no channel assigned
        $no_channels = Source::where('channel_id', null)->get();
        $no_channel_count = Source::where('channel_id', null)->count();

        // Sources for each channel
        $organic_searches = Source::where('channel_id', 1)->get();
        $organic_search_count = Source::where('channel_id', 1)->count();

        $paid_searches = Source::where('channel_id', 2)->get();
        $paid_search_count = Source::where('channel_id', 2)->count();

        $organic_socials = Source::where('channel_id', 3)->get();
        $organic_social_count = Source::where('channel_id', 3)->count();

        $paid_socials = Source::where('channel_id', 4)->get();
        $paid_social_count = Source::where('channel_id', 4)->count();

        $emails = Source::where('channel_id', 5)->get();
        $email_count = Source::where('channel_id', 5)->count();

        $direct_traffics = Source::where('channel_id', 6)->get();
        $direct_traffic_count = Source::where('channel_id', 6)->count();

        $referral_traffics = Source::where('channel_id', 7)->get();
        $referral_traffic_count = Source::where('channel_id', 7)->count();

        $traditionals = Source::where('channel_id', 8)->get();
        $traditional_count = Source::where('channel_id', 8)->count();

        return view('admin.settings.channel_source', compact(
            'all_channels',
            'no_channels',
            'no_channel_count',
            'organic_searches',
            'organic_search_count',
            'paid_searches',
            'paid_search_count',
            'organic_socials',
            'organic_social_count',
            'paid_socials',
            'paid_social_count',
            'emails',
            'email_count',
            'direct_traffics',
            'direct_traffic_count',
            'referral_traffics',
            'referral_traffic_count',
            'traditionals',
            'traditional_count'
        ));
    }

    public function source_store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required',
        ]);

        $data = [
            'name' => $validated['name'],
            'channel_id' => $request->input('channel_id') ?: null,
        ];

        $source = Source::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Source added successfully.',
                'source' => $source,
            ]);
        }

        return redirect()->back()->with('success', 'Source added successfully.');

    }

    public function source_update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $source = Source::findOrFail($id);
        $source->update([
            'name' => $validated['name'],
            'channel_id' => $request->input('channel_id') ?: null,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Source updated successfully.',
                'company' => $source,
            ]);
        }

        return redirect()->back()->with('success', 'Source updated successfully.');
    }

    public function company_type()
    {

        $company_types = CompanyType::all();
        $totalCounts = CompanyType::count();

        return view('admin.settings.company_type', compact('company_types', 'totalCounts'));
    }

    public function company_type_store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required',
        ]);

        $data = [
            'type' => $validated['name'],
        ];

        $company_type = CompanyType::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Company type added successfully.',
                'company' => $company_type,
            ]);
        }

        return redirect()->back()->with('success', 'Company type added successfully.');
    }

    public function company_type_update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $company_type = CompanyType::findOrFail($id);
        $company_type->update([
            'type' => $validated['name'],
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Company type updated successfully.',
                'company' => $company_type,
            ]);
        }

        return redirect()->back()->with('success', 'Company type updated successfully.');
    }

    public function market()
    {

        $currencies = Currency::all();
        $markets = Market::with('currency')->get();
        $totalCounts = Market::count();

        return view('admin.settings.market', compact('markets', 'totalCounts', 'currencies'));

    }

    public function market_store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required',
            'currency_id' => 'required',
        ]);

        $data = [
            'name' => $validated['name'],
            'currency_id' => $validated['currency_id'],
        ];

        $market = Market::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Market added successfully.',
                'market' => $market,
            ]);
        }

        return redirect()->back()->with('success', 'Market added successfully.');

    }

    public function market_update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'currency_id' => 'required',
        ]);

        $market = Market::findOrFail($id);
        $market->update([
            'name' => $validated['name'],
            'currency_id' => $validated['currency_id'],
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Market updated successfully.',
                'market' => $market,
            ]);
        }

        return redirect()->back()->with('success', 'Market updated successfully.');
    }

    public function tag()
    {
        $colors = [
            '#000000',
            '#f8d7da',
            '#fce5cd',
            '#fff2cc',
            '#d9ead3',
            '#d0e0e3',
            '#d9d2e9',
            '#cccccc',
            '#ea9999',
            '#f6b26b',
            '#ffe599',
            '#b6d7a8',
            '#a2c4c9',
            '#b4a7d6',
        ];
        // $tags = Tag::with('user')->get();
        $leadtags = Tag::with('user')->where('tag_id', 1)->get();
        $leadcount = Tag::where('tag_id', 1)->count();
        $companytags = Tag::with('user')->where('tag_id', 2)->get();
        $companycount = Tag::where('tag_id', 2)->count();
        $persontags = Tag::with('user')->where('tag_id', 3)->get();
        $personcount = Tag::where('tag_id', 3)->count();

        return view('admin.settings.tag', compact('leadtags', 'leadcount', 'companycount', 'personcount', 'companytags', 'persontags', 'colors'));
    }

    public function tag_store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required',
            'color' => 'required',
            'tag_id' => 'required',
        ]);

        $data = [
            'name' => $validated['name'],
            'color' => $validated['color'],
            'tag_id' => $validated['tag_id'],
            'created_by' => auth()->id(),
        ];

        $tag = Tag::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tag added successfully.',
                'tag' => $tag,
            ]);
        }

        return redirect()->back()->with('success', 'Tag added successfully.');
    }

    public function tag_update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'color' => 'required',
            'tag_id' => 'required',
        ]);

        $tag = Tag::findOrFail($id);
        
        $tag->update([
            'name' => $validated['name'],
            'color' => $validated['color'],
            'tag_id' => $validated['tag_id'],
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tag updated successfully.',
                'tag' => $tag,
            ]);
        }

        return redirect()->back()->with('success', 'Tag updated successfully.');
    }

    public function product()
    {
        $products = Product::all();
        $product_types = ['Good', 'Service'];
        $productCount = Product::count();

        return view('admin.settings.product', compact('products', 'productCount', 'product_types'));
    }

    public function product_store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required',
            'product_type' => 'required',
            'sku' => 'required',
            'us_price' => 'required',
        ]);

        $data = [
            'name' => $validated['name'],
            'product_type' => $validated['product_type'],
            'sku' => $validated['sku'],
            'price' => $validated['us_price'],

        ];
        // $data['availability'] = $request->filled('availability') ?: 0;
        // $data['availability'] = $request->has('');

        $product = Product::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added successfully.',
                'market' => $product,
            ]);
        }

        return redirect()->back()->with('success', 'Product added successfully.');
    }

    public function product_update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'product_type' => 'required',
            'sku' => 'required',
            'us_price' => 'required',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'name' => $validated['name'],
            'product_type' => $validated['product_type'],
            'sku' => $validated['sku'],
            'price' => $validated['us_price'],
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully.',
                'product' => $product,
            ]);
        }

        return redirect()->back()->with('success', 'Product updated successfully.');
    }

    public function territory()
    {
        $territories = Territory::with('locations')->get();
        foreach ($territories as $territory) {
            foreach ($territory->locations as $loc) {
                if ($loc->state) {
                    $state = \App\Models\State::find($loc->state);
                    $loc->state_name = $state ? $state->name : 'Unknown';
                }
                if ($loc->city) {
                    $city = \App\Models\City::find($loc->city);
                    $loc->city_name = $city ? $city->name : 'Unknown';
                }
            }
        }

        return view('admin.settings.territory', compact('territories'));
    }

    public function territory_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'franchise_name' => 'required|string|max:255',
        ]);

        $territory = Territory::create([
            'name' => $request->name,
            'franchise_name' => $request->franchise_name,
        ]);

        return response()->json(['success' => true, 'message' => 'Territory added successfully!']);
    }

    public function territory_update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'franchise_name' => 'required|string|max:255',
        ]);

        $territory = Territory::findOrFail($id);
        $territory->update([
            'name' => $request->name,
            'franchise_name' => $request->franchise_name,
        ]);

        return response()->json(['success' => true, 'message' => 'Territory updated successfully!']);
    }

    public function territory_update_locations(Request $request, $id)
    {
        $request->validate([
            'locations' => 'required|array|min:1',
        ]);

        $territory = Territory::findOrFail($id);
        
        // Delete old locations and insert new ones
        $territory->locations()->delete();

        foreach ($request->locations as $loc) {
            $type = 'country'; // default
            if (!empty($loc['city'])) $type = 'city';
            elseif (!empty($loc['state_province'])) $type = 'state';
            elseif (!empty($loc['postal_code'])) $type = 'postal';
            elseif (!empty($loc['area_code'])) $type = 'area';

            TerritoryLocation::create([
                'territory_id' => $territory->id,
                'type' => $type,
                'country' => $loc['country'] ?? null,
                'state' => $loc['state_province'] ?? null,
                'city' => $loc['city'] ?? null,
                'postal_code' => $loc['postal_code'] ?? null,
                'area_code' => $loc['area_code'] ?? null,
                'range' => $loc['range'] ?? null,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Location rules updated successfully!']);
    }

    public function getStatesByCountry($countryId)
    {
        $states = Helper::getStatesByCountryId($countryId);

        return response()->json($states);
    }

    public function getCitiesByState($stateId)
    {
        $cities = Helper::getCitiesByStateId($stateId);

        return response()->json($cities);
    }
}
