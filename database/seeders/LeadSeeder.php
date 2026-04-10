<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lead;
use App\Models\LeadStageProcess;
use App\Models\SurveyProposal;
use App\Models\User;
use App\Models\Company;
use App\Models\Product;
use App\Models\People;
use App\Models\Source;
use App\Models\Competitor;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class LeadSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereHas('roles', function ($q) {
            $q->whereNotIn('name', ['customer']);
        })->pluck('id')->toArray();
        $companies = Company::pluck('id')->toArray();
        $products = Product::pluck('id')->toArray();
        $peoples = People::pluck('id')->toArray();
        $sources = Source::pluck('id')->toArray();
        $competitors = Competitor::pluck('id')->toArray();
        $tags = Tag::pluck('id')->toArray();

        $leads = [];

        for ($i = 1; $i <= 10; $i++) {
            $leads[] = [
                'name' => "Sample Lead $i",
                'assignee_id' => $users[array_rand($users)] ?? null,
                'company_id' => $companies[array_rand($companies)],
                'close_date' => now()->addDays(rand(5, 30)),
                'confidence' => rand(10, 100),
            ];
        }

        foreach ($leads as $leadData) {
            DB::transaction(function () use (
                $leadData, $products, $peoples, $sources, $competitors, $tags
            ) {

                $lead = Lead::create([
                    'name' => $leadData['name'],
                    'assignee_id' => $leadData['assignee_id'],
                    'company_id' => $leadData['company_id'],
                    'close_date' => $leadData['close_date'],
                    'confidence' => $leadData['confidence'],
                    'creator_id' => 1, // or random user if needed
                    'lead_status' => 'open',
                ]);

                LeadStageProcess::create([
                    'lead_id' => $lead->id,
                ]);

                SurveyProposal::create([
                    'user_id' => 1,
                    'lead_id' => $lead->id,
                    'company_id' => $lead->company_id,
                ]);

                // Attach Peoples
                if (!empty($peoples)) {
                    $lead->peoples()->attach(
                        collect($peoples)->random(rand(1, min(2, count($peoples))))
                    );
                }

                // Attach Products with qty & price
                if (!empty($products)) {
                    $selectedProducts = collect($products)->random(rand(1, min(3, count($products))));

                    foreach ((array)$selectedProducts as $productId) {
                        $lead->products()->attach($productId, [
                            'qty' => rand(1, 5),
                            'price' => rand(100, 1000),
                        ]);
                    }
                }

                // Sources
                if (!empty($sources)) {
                    $lead->sources()->attach(
                        collect($sources)->random(rand(1, min(2, count($sources))))
                    );
                }

                // Competitors
                if (!empty($competitors)) {
                    $lead->competitors()->attach(
                        collect($competitors)->random(rand(1, min(2, count($competitors))))
                    );
                }

                // Tag (single as per form)
                if (!empty($tags)) {
                    $lead->tags()->attach(
                        collect($tags)->random(1)
                    );
                }
            });
        }
    }
}
