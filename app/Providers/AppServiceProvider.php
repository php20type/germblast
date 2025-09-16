<?php

namespace App\Providers;

use App\Helpers\Helper;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Interfaces\CountryRepositoryInterface;
use App\Repositories\CountryRepository;
use App\Interfaces\StateRepositoryInterface;
use App\Repositories\StateRepository;
use App\Interfaces\CityRepositoryInterface;
use App\Repositories\CityRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(StateRepositoryInterface::class, StateRepository::class);
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
         $this->app->singleton('helper', function ($app) {
            return new Helper;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
