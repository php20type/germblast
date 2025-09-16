<?php

namespace App\Repositories;

use App\Models\City;
use App\Interfaces\CityRepositoryInterface;

class CityRepository implements CityRepositoryInterface
{

    protected $model;

    public function __construct(City $city)
    {
        $this->model = $city;
    }

    public function getAll()
    {
        return $this->model::all();
    }

    public function getCitiesByStateId($stateId)
    {
        return $this->model::where('state_id', $stateId)->get();
    }
}
