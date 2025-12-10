<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'zoom_access_token',
        'zoom_refresh_token',
        'zoom_token_expiry'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function task()
    {
        return $this->hasMany(Task::class, 'user_id');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'assingee_id');
    }

    public function company()
    {
        return $this->hasMany(Company::class, 'user_id');
    }

    public function people()
    {
        return $this->hasMany(People::class, 'user_id');
    }

    public function tag()
    {
        return $this->hasMany(Tag::class, 'created_by');
    }

    public function activity()
    {
        return $this->hasMany(Activity::class, 'user_id');
    }

    public function activityComments()
    {
        return $this->hasMany(ActivityComment::class, 'user_id');
    }

    public function note()
    {
        return $this->hasMany(Note::class, 'user_id');
    }

    public function timeline()
    {
        return $this->hasMany(Timeline::class, 'user_id');
    }

    public function noteComments()
    {
        return $this->hasMany(NoteComment::class, 'user_id');
    }

    public function companyFile()
    {
        return $this->hasMany(CompanyFile::class, 'user_id');
    }

    public function peopleFile()
    {
        return $this->hasMany(PeopleFile::class, 'user_id');
    }

    public function leadFile()
    {
        return $this->hasMany(LeadFile::class, 'user_id');
    }

    public function taskAssignee()
    {
        return $this->hasMany(Task::class, 'assignee_id');
    }

    public function taskCompleted()
    {
        return $this->hasMany(Task::class, 'completed_user_id');
    }

    public function surveyProposal()
    {
        return $this->hasMany(SurveyProposal::class, 'user_id');
    }

    public function equipmentEvaluation()
    {
        return $this->hasMany(EquipmentEvaluation::class, 'user_id');
    }

    public function surveyFacility()
    {
        return $this->hasMany(SurveyFacility::class, 'user_id');
    }

    public function surveyFacilityMap()
    {
        return $this->hasMany(SurveyFacilityMap::class, 'user_id');
    }

    public function surveyFacilityAtp()
    {
        return $this->hasMany(SurveyFacilityAtp::class, 'user_id');
    }

    public function surveyEquipmentImage()
    {
        return $this->hasMany(SurveyEquipmentImage::class, 'user_id');
    }

    public function initialMeetingCompleted()
    {
        return $this->hasMany(LeadStageProcess::class, 'initial_meeting_completed_by');
    }

    public function siteSurveyCompleted()
    {
        return $this->hasMany(LeadStageProcess::class, 'site_survey_completed_by');
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class,'user_id');
    }
}
