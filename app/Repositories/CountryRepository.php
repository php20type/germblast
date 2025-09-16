<?php

namespace App\Repositories;

use App\Models\Country;
use App\Interfaces\CountryRepositoryInterface;

class CountryRepository implements CountryRepositoryInterface
{
    protected $model;

    public function __construct(Country $country)
    {
        $this->model = $country;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getCountryByName($name)
    {
        return $this->model->where('name', $name)->first();
    }
}

