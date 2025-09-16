<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface CountryRepositoryInterface
{
    public function getAll();
    public function getCountryByName($name);
}
