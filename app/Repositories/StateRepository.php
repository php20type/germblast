<?php

namespace App\Repositories;

use App\Models\State;
use App\Interfaces\StateRepositoryInterface;

class StateRepository implements StateRepositoryInterface
{

    protected $model;

    public function __construct(State $state)
    {
        $this->model = $state;
    }

    public function getAll()
    {
        return $this->model::all();
    }


    public function getStatesByCountryId($countryId)
    {
        return $this->model::where('country_id', $countryId)->get();
    }

}
