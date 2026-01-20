<?php

namespace App\Providers;

use App\Helpers\Helper;
use App\Interfaces\CityRepositoryInterface;
use App\Interfaces\CompanyRepositoryInterface;
use App\Interfaces\CountryRepositoryInterface;
use App\Interfaces\LeadRepositoryInterface;
use App\Interfaces\PeopleRepositoryInterface;
use App\Interfaces\StateRepositoryInterface;
use App\Repositories\CityRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\CountryRepository;
use App\Repositories\LeadRepository;
use App\Repositories\PeopleRepository;
use App\Repositories\StateRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

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
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(PeopleRepositoryInterface::class, PeopleRepository::class);
        $this->app->bind(LeadRepositoryInterface::class, LeadRepository::class);
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

         Relation::morphMap([
        'Company' => \App\Models\Company::class,
        'People'  => \App\Models\People::class,
        'Lead'    => \App\Models\Lead::class,
        // 'User'    => \App\Models\User::class,
    ]);
    }
}
