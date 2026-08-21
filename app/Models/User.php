<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'territory_id',
        'staff_type',
        'role',
        'zoom_access_token',
        'zoom_refresh_token',
        'zoom_token_expiry',

        'cell_phone',
        'profile_image',
        'hourly_rate',
        'overtime_rate',
        'training_level',
        'employee_type',
        'active',
        'schedulable',
        'biological_response_team',
        'healthcare_team',
        'driver_trained',
        'floor_certified',
        'driver_status',
        'driver_points',
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

    // =====================
    // Roles
    // =====================
    public function isCustomer(): bool
    {
        return $this->hasRole('customer');
    }

    public function isTechnician(): bool
    {
        return $this->hasRole('technician');
    }

    public function isWarehouseTechnician(): bool
    {
        return $this->hasRole('warehouse_technician');
    }

    public function isTrainingSupervisor(): bool
    {
        return $this->hasRole('training_supervisor');
    }

    public function isSupervisor(): bool
    {
        return $this->hasRole('supervisor');
    }

    public function isJobManager(): bool
    {
        return $this->hasRole('job_manager');
    }

    public function isWarehouseManager(): bool
    {
        return $this->hasRole('warehouse_manager');
    }

    public function isSalesRepresentative(): bool
    {
        return $this->hasRole('sales_representative');
    }

    public function isSalesTeam(): bool
    {
        return $this->hasRole('sales_team');
    }

    public function isSalesManager(): bool
    {
        return $this->hasRole('sales_manager');
    }

    public function isAssistantOperationsManager(): bool
    {
        return $this->hasRole('assistant_operations_manager');
    }

    public function isOperationsManager(): bool
    {
        return $this->hasRole('operations_manager');
    }

    public function isRegionalOperationsManager(): bool
    {
        return $this->hasRole('regional_operations_manager');
    }

    public function isFieldEpidemiologyTeam(): bool
    {
        return $this->hasRole('field_epidemiology_team');
    }

    public function isCorporateTeam(): bool
    {
        return $this->hasRole('corporate_team');
    }

    public function isSeniorCorporate(): bool
    {
        return $this->hasRole('senior_corporate');
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    // =====================
    // Specialties / Capabilities
    // =====================
    public function isBiologicalResponder(): bool
    {
        return (bool) $this->biological_response_team;
    }

    public function isHealthcareTechnician(): bool
    {
        return (bool) $this->healthcare_team;
    }

    public function isDriverTrained(): bool
    {
        return (bool) $this->driver_trained;
    }

    public function isFloorCertified(): bool
    {
        return (bool) $this->floor_certified;
    }

    public function getSpecialtiesAttribute(): array
    {
        $specialties = [];

        if ($this->isDriverTrained())           $specialties[] = 'Trained Driver';
        if ($this->isHealthcareTechnician())    $specialties[] = 'Healthcare Technician';
        if ($this->isBiologicalResponder())     $specialties[] = 'Biological Responder';

        return $specialties;
    }
    // =====================================

    public function task()
    {
        return $this->hasMany(Task::class, 'user_id');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'assignee_id');
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
        return $this->hasMany(Meeting::class, 'user_id');
    }

    public function mentionedMeetings()
    {
        return $this->belongsToMany(Meeting::class, 'meeting_users', 'user_id', 'meeting_id')->withTimestamps();
    }

    public function assignedPeople()
    {
        return $this->hasMany(People::class, 'assignee_id');
    }

    public function assignedCompanies()
    {
        return $this->hasMany(Company::class, 'assignee_id');
    }

    public function salesRepCompanies()
    {
        return $this->hasMany(Company::class, 'sales_rep_id');
    }

    public function accountManagedCompanies()
    {
        return $this->hasMany(Company::class, 'account_manager_id');
    }

    public function proposalComments()
    {
        return $this->hasMany(ProposalComment::class,'user_id');
    }

    public function proposalActions()
    {
        return $this->hasMany(ProposalAction::class, 'user_id');
    }

    public function service()
    {
        return $this->hasMany(Service::class, 'user_id');
    }

    public function serviceOrderUser()
    {
        return $this->hasMany(ServiceOrder::class, 'user_id');
    }

    public function serviceOrderSlotClockedBy()
    {
        return $this->hasMany(ServiceOrderSlotClock::class, 'clocked_by');
    }

    public function serviceOrderConfirmedBy()
    {
        return $this->hasMany(ServiceOrderSlot::class, 'confirmed_by');
    }

    public function serviceNoteUser()
    {
        return $this->hasMany(ServiceNote::class, 'user_id');
    }

    public function serviceNotePerson()
    {
        return $this->hasMany(ServiceNote::class, 'person_id');
    }

    public function territory()
    {
        return $this->belongsTo(Territory::class,'territory_id');
    }

    public function staff()
    {
        return $this->hasMany(ServiceOrderSlotStaff::class, 'user_id');
    }


    public function maskTestRecord()
    {
        return $this->hasMany(MaskFitTestRecord::class, 'user_id');
    }

    public function driverLogs()
    {
        return $this->hasMany(DriverLog::class, 'user_id');
    }

    public function driverSuspensionRecords()
    {
        return $this->hasMany(DriverSuspensionRecord::class,'user_id');
    }

    public function performanceRecordAddedBy()
    {
        return $this->hasMany(ServiceOrderEmployeePerformance::class, 'user_id');
    }

    public function performanceRecords()
    {
        return $this->hasMany(ServiceOrderEmployeePerformance::class, 'employee_id');
    }

    public function equipmentStatusLogs()
    {
        return $this->hasMany(EquipmentStatusLog::class, 'changed_by');
    }

    public function consumableReports()
    {
        return $this->hasMany(ConsumableReport::class, 'user_id');
    }

    public function timeOffRequests()
    {
        return $this->hasMany(TimeOffRequest::class, 'user_id');
    }

    public function rewards()
    {
        return $this->hasMany(EmployeeReward::class, 'user_id');
    }

    public function jobClockAuditLogs()
    {
        return $this->hasMany(JobClockAuditLog::class, 'user_id');
    }

    public function availabilities()
    {
        return $this->hasMany(EmployeeAvailability::class, 'user_id')->orderBy('start_date', 'desc');
    }

    public function timecards()
    {
        return $this->hasMany(Timecard::class, 'user_id');
    }

    public function disciplineRecords()
    {
        return $this->hasMany(EmployeePerformanceRecord::class, 'user_id');
    }

    public function actionPlans()
    {
        return $this->hasMany(ActionPlan::class, 'user_id');
    }

    public function resolvedActionPlans()
    {
        return $this->hasMany(ActionPlan::class, 'resolved_by');
    }
    public function evaluationRequests()
    {
        return $this->hasMany(EvaluationRequest::class, 'target_user_id');
    }

    public function sitAttempts()
    {
        return $this->hasMany(SitEvaluationAttempt::class, 'technician_id');
    }

    public function evaluationScores()
    {
        return $this->hasMany(EvaluationScore::class, 'target_user_id');
    }

    public function warehouseTaskCompletions()
    {
        return $this->hasMany(WarehouseTaskCompletion::class, 'user_id');
    }
}
