<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface StateRepositoryInterface
{
    public function getAll();
    public function getStatesByCountryId($countryId);
}
