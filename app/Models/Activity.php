<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_type_id',
        'user_id',
        'owner_type',
        'owner_id',
        'all_day',
        'date',
        'start_time',
        'end_time',
        'location',
        'description',
        'note',
        'status',
    ];

    protected $with = ['activityType', 'creator'];

    // Relation to activity type
    public function activityType()
    {
        return $this->belongsTo(ActivityType::class, 'activity_type_id');
    }

    // Polymorphic relation to owner (company, people, lead)
    public function owner()
    {
        return $this->morphTo(null, 'owner_type', 'owner_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation to companies related to this activity
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'activity_related_companies', 'activity_id', 'company_id');
    }

    // Relation to peoples related to this activity
    public function peoples()
    {
        return $this->belongsToMany(People::class, 'activity_related_people', 'activity_id', 'people_id');
    }

    // Relation to leads related to this activity
    public function leads()
    {
        return $this->belongsToMany(Lead::class, 'activity_related_leads', 'activity_id', 'lead_id');
    }

    // Relation to users related to this activity
    public function users()
    {
        return $this->belongsToMany(User::class, 'activity_related_users', 'activity_id', 'user_id');
    }

    // Relation to companies mentioned in this activity
    public function mentionCompanies()
    {
        return $this->belongsToMany(Company::class, 'activity_mention_companies', 'activity_id', 'company_id');
    }

    // Relation to peoples mentioned in this activity
    public function mentionPeoples()
    {
        return $this->belongsToMany(People::class, 'activity_mention_people', 'activity_id', 'people_id');
    }

    // Relation to leads mentioned in this activity
    public function mentionLeads()
    {
        return $this->belongsToMany(Lead::class, 'activity_mention_leads', 'activity_id', 'lead_id');
    }

    // Relation to users mentioned in this activity
    public function mentionUsers()
    {
        return $this->belongsToMany(User::class, 'activity_mention_users', 'activity_id', 'user_id');
    }
}
