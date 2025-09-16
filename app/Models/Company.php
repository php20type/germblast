<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'legacy_id',
        'postalCode',
        'industry_id',
        'company_type_id',
        'territory_id',
        'tag_id',
        'country_id',
        'state_id',
        'city_id',
        'annual_revenue',
        'employees_count',
    ];

    protected $with = ['companyEmail', 'companyPhone', 'companyAddress', 'companyUrl', 'companyPeople', 'companyTask'];

    // public function people()
    // {
    //     return $this->hasMany(People::class, 'company_id');
    // }

    public function leadSource()
    {
        return $this->hasMany(LeadSource::class, 'source_id');
    }

    // New relation according to the new migration
    // ===============================================================


    /**
     * Belongs to relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }

    public function companyType()
    {
        return $this->belongsTo(CompanyType::class, 'company_type_id');
    }

    public function territory()
    {
        return $this->belongsTo(Territory::class, 'territory_id');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * Has One relationships
     */
    public function companyAddress()
    {
        return $this->hasOne(CompanyAddress::class, 'company_id');
    }

    public function companyEmail()
    {
        return $this->hasOne(CompanyEmail::class, 'company_id');
    }

    public function companyPhone()
    {
        return $this->hasOne(CompanyPhone::class, 'company_id');
    }

    public function companyUrl()
    {
        return $this->hasOne(CompanyUrl::class, 'company_id');
    }
    public function companyTask()
    {
        return $this->hasMany(CompanyTask::class, 'company_id');
    }

    // Company People pivot table
    public function companyPeople()
    {
        return $this->hasMany(CompanyPeople::class, 'company_id');
    }
    public function peoples()
    {
        return $this->belongsToMany(People::class, 'company_peoples')
            ->withTimestamps();
    }

    // People Company pivot table
    public function peopleCompany()
    {
        return $this->hasMany(PeopleCompany::class, 'company_id');
    }
    public function peoplesAlt()
    {
        return $this->belongsToMany(People::class, 'people_companies')
            ->withTimestamps();
    }


    // Lead Company pivot table
    public function leadCompanies()
    {
        return $this->hasMany(LeadCompany::class, 'company_id');
    }
    public function leads()
    {
        return $this->belongsToMany(Lead::class, 'lead_companies')
            ->withTimestamps();
    }

}
