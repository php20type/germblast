<?php

namespace App\Helpers;

use App\Interfaces\CityRepositoryInterface;
use App\Interfaces\CountryRepositoryInterface;
use App\Interfaces\StateRepositoryInterface;
use App\Models\Activity;

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

    public static function calculateTotalValue($leads)
    {
        return $leads->sum(function ($lead) {
            return $lead->products->sum(function ($product) {
                return $product->pivot->qty * $product->pivot->price;
            });
        });
    }

    public static function formatValue($value)
    {
        if ($value >= 1000000) {
            return round($value / 1000000, 1).'m';
        } elseif ($value >= 1000) {
            return round($value / 1000, 1).'k';
        }

        return $value;
    }

    public static function getActivitiesForParticipant(string $entityType, int $entityId)
    {
        $query = Activity::query()->with(['companies', 'peoples', 'leads', 'users','activityType']);

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
    }
}
