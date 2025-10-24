<?php

namespace App\Helpers;

use App\Interfaces\CityRepositoryInterface;
use App\Interfaces\CountryRepositoryInterface;
use App\Interfaces\StateRepositoryInterface;
use App\Models\Activity;
use App\Models\Lead;
use App\Models\Note;

class Helper
{
    // For Countries
    public static function getCountries()
    {
        return app(CountryRepositoryInterface::class)->getAll();
    }

    public static function getStates()
    {
        return app(StateRepositoryInterface::class)->getAll();
    }

    public static function getCities()
    {
        return app(CityRepositoryInterface::class)->getAll();
    }

    public static function getStatesByCountryId($countryId)
    {
        return app(StateRepositoryInterface::class)->getStatesByCountryId($countryId);
    }

    // For Cities
    public static function getCitiesByStateId($stateId)
    {
        return app(CityRepositoryInterface::class)->getCitiesByStateId($stateId);
    }

    // public static function calculateTotalValue($leads)
    // {
    //     return collect($leads)->sum(fn ($lead)
    //     => $lead->products->sum(fn ($product)
    //     => $product->pivot->qty * $product->pivot->price
    //     )
    //     );
    // }

    public static function calculateTotalValue($leads)
    {
        // If a single Lead model is passed, wrap it into a collection
        if ($leads instanceof Lead) {
            $leads = collect([$leads]);
        }

        return collect($leads)->sum(fn ($lead) => $lead->products->sum(fn ($product) => $product->pivot->qty * $product->pivot->price
        )
        );
    }

    // public static function formatValue($value)
    // {
    //     if ($value >= 1000000) {
    //         return round($value / 1000000, 1).'m';
    //     } elseif ($value >= 1000) {
    //         return round($value / 1000, 1).'k';
    //     }

    //     return $value;
    // }
    public static function formatValue($value)
    {
        if ($value >= 1000000) {
            return round($value / 1000000, 1).'m';
        } elseif ($value >= 1000) {
            return round($value / 1000, 1).'k';
        }

        // For values less than 1000, just return as-is
        return (string) $value;
    }

    public static function getActivitiesForParticipant(string $entityType, int $entityId)
    {
        $query = Activity::query()->with(['companies', 'peoples', 'leads', 'users', 'activityType']);

        switch ($entityType) {
            case 'company':
                $query->whereHas('companies', fn ($q) => $q->where('company_id', $entityId));
                break;
            case 'people':
                $query->whereHas('peoples', fn ($q) => $q->where('people_id', $entityId));
                break;
            case 'lead':
                $query->whereHas('leads', fn ($q) => $q->where('lead_id', $entityId));
                break;
            case 'user':
                $query->whereHas('users', fn ($q) => $q->where('user_id', $entityId));
                break;
            default:
                return collect(); // return empty collection if entity type is invalid
        }

        return $query->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();
        //  return $query->orderBy('created_at', 'desc')->get();
    }

    public static function getNotesForParticipant(string $entityType, int $entityId)
    {
        $query = Note::query()->with(['companies', 'peoples', 'users', 'owner']);

        switch ($entityType) {
            case 'company':
                $query->where('owner_type', 'Company')->where('owner_id', $entityId);
                break;

            case 'people':
                $query->where('owner_type', 'People')->where('owner_id', $entityId);
                break;

            case 'lead':
                $query->where('owner_type', 'Lead')->where('owner_id', $entityId);
                break;

            case 'user':
                $query->where('owner_type', 'User')->where('owner_id', $entityId);
                break;

            default:
                return collect(); // empty if invalid entity type
        }

        return $query->orderBy('created_at', 'desc')->get();
    }
}
