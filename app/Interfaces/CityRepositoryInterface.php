<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface CityRepositoryInterface
{
    public function getAll();
    public function getCitiesByStateId($stateId);
}
