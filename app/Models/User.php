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
        'role'
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
        return $this->hasMany(Task::class,'user_id');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class,'assingee_id');
    }

    public function company()
    {
        return $this->hasMany(Company::class,'user_id');
    }

    public function people()
    {
        return $this->hasMany(People::class,'user_id');
    }

     public function tag()
    {
        return $this->hasMany(Tag::class, 'created_by');
    }

     public function companyTaskAssignee()
    {
        return $this->hasMany(CompanyTask::class, 'assignee_id');
    }

    public function companyTaskCompleted()
    {
        return $this->hasMany(CompanyTask::class, 'completed_user_id');
    }

    public function peopleTaskAssignee()
    {
        return $this->hasMany(PeopleTask::class, 'assignee_id');
    }

    public function peopleTaskCompleted()
    {
        return $this->hasMany(PeopleTask::class, 'completed_user_id');
    }

    public function leadTaskAssignee()
    {
        return $this->hasMany(LeadTask::class, 'assignee_id');
    }

    public function leadTaskCompleted()
    {
        return $this->hasMany(LeadTask::class, 'completed_user_id');
    }

}
