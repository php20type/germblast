<?php

namespace App\Helpers;

use App\Interfaces\CountryRepositoryInterface;
use App\Interfaces\StateRepositoryInterface;
use App\Interfaces\CityRepositoryInterface;


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

}
