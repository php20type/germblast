<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'lead_number',
        'name',
        'description',
        'lead_status',
        'lead_flags',
        'stage_id',
        'confidence',
        'unknown_field',
        'creator_id',
        'assignee_id',
        'close_date',
        'last_contacted',
        'last_modified',
        'market_id',
        'outcome_id',
        'created_at'
    ];

     protected $with = ['leadCompanies', 'leadProducts', 'leadPeople', 'leadSources', 'leadCompetitors', 'leadTags', 'leadTask'];

    protected $casts = [
        'close_date' => 'datetime',
        'lead_flags' => 'array',
    ];

    // Companies pivot table
    public function leadCompanies()
    {
        return $this->hasMany(LeadCompany::class, 'lead_id');
    }
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'lead_companies')
            ->withTimestamps();
    }

    // Products pivot table
    public function leadProducts()
    {
        return $this->hasMany(LeadProduct::class, 'lead_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'lead_products')
            ->withPivot(['qty', 'price']) // extra fields
            ->withTimestamps();
    }

    // People pivot table
    public function leadPeople()
    {
        return $this->hasMany(LeadPeople::class, 'lead_id');
    }
    public function peoples()
    {
        return $this->belongsToMany(People::class, 'lead_peoples')
            ->withTimestamps();
    }

    // Sources pivot table
    public function leadSources()
    {
        return $this->hasMany(LeadSource::class, 'lead_id');
    }
    public function sources()
    {
        return $this->belongsToMany(Source::class, 'lead_sources')
            ->withTimestamps();
    }

    // Competitors pivot table
    public function leadCompetitors()
    {
        return $this->hasMany(LeadCompetitor::class, 'lead_id');
    }
    public function competitors()
    {
        return $this->belongsToMany(Competitor::class, 'lead_competitors')
            ->withTimestamps();
    }

    // Tags pivot table
    public function leadTags()
    {
        return $this->hasMany(LeadTag::class, 'lead_id');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'lead_tags')
            ->withTimestamps();
    }

    // Other foreign key fields relations
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    public function market()
    {
        return $this->belongsTo(Market::class, 'market_id');
    }
    public function outcome()
    {
        return $this->belongsTo(Outcome::class, 'outcome_id');
    }
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }
    public function stages()
    {
        return $this->belongsTo(LeadStage::class, 'stage_id');
    }
    public function leadTask()
    {
        return $this->hasMany(LeadTask::class, 'lead_id');
    }
}
