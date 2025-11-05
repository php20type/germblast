<?php

namespace App\Helpers;

use App\Interfaces\CityRepositoryInterface;
use App\Interfaces\CountryRepositoryInterface;
use App\Interfaces\StateRepositoryInterface;
use App\Models\Activity;
use App\Models\Lead;
use App\Models\Note;
use App\Models\Timeline;

class Helper
{
    // For Countries
    public static function getCountries()
    {
        return app(CountryRepositoryInterface::class)->getAll();
    }

    public static function getStates()
    {
        return app(StateRepositoryInterface::class)->getAll();
    }

    public static function getCities()
    {
        return app(CityRepositoryInterface::class)->getAll();
    }

    public static function getStatesByCountryId($countryId)
    {
        return app(StateRepositoryInterface::class)->getStatesByCountryId($countryId);
    }

    // For Cities
    public static function getCitiesByStateId($stateId)
    {
        return app(CityRepositoryInterface::class)->getCitiesByStateId($stateId);
    }

    // public static function calculateTotalValue($leads)
    // {
    //     return collect($leads)->sum(fn ($lead)
    //     => $lead->products->sum(fn ($product)
    //     => $product->pivot->qty * $product->pivot->price
    //     )
    //     );
    // }

    public static function calculateTotalValue($leads)
    {
        // If a single Lead model is passed, wrap it into a collection
        if ($leads instanceof Lead) {
            $leads = collect([$leads]);
        }

        return collect($leads)->sum(fn ($lead) => $lead->products->sum(fn ($product) => $product->pivot->qty * $product->pivot->price
        )
        );
    }

    // public static function formatValue($value)
    // {
    //     if ($value >= 1000000) {
    //         return round($value / 1000000, 1).'m';
    //     } elseif ($value >= 1000) {
    //         return round($value / 1000, 1).'k';
    //     }

    //     return $value;
    // }
    public static function formatValue($value)
    {
        if ($value >= 1000000) {
            return round($value / 1000000, 1).'m';
        } elseif ($value >= 1000) {
            return round($value / 1000, 1).'k';
        }

        // For values less than 1000, just return as-is
        return (string) $value;
    }

    public static function getActivitiesForParticipant(string $entityType, int $entityId)
    {
        $query = Activity::query()->with(['companies', 'peoples', 'leads', 'users', 'activityType', 'mentionCompanies', 'mentionPeoples', 'mentionUsers']);

        // switch ($entityType) {
        //     case 'company':
        //         $query->whereHas('companies', fn ($q) => $q->where('company_id', $entityId));
        //         break;
        //     case 'people':
        //         $query->whereHas('peoples', fn ($q) => $q->where('people_id', $entityId));
        //         break;
        //     case 'lead':
        //         $query->whereHas('leads', fn ($q) => $q->where('lead_id', $entityId));
        //         break;
        //     case 'user':
        //         $query->whereHas('users', fn ($q) => $q->where('user_id', $entityId));
        //         break;
        //     default:
        //         return collect(); // return empty collection if entity type is invalid
        // }
        switch ($entityType) {
            case 'company':
                $query->where(function ($q) use ($entityId) {
                    $q->whereHas('companies', fn ($sub) => $sub->where('company_id', $entityId))
                        ->orWhereHas('mentionCompanies', fn ($sub) => $sub->where('company_id', $entityId));
                });
                break;

            case 'people':
                $query->where(function ($q) use ($entityId) {
                    $q->whereHas('peoples', fn ($sub) => $sub->where('people_id', $entityId))
                        ->orWhereHas('mentionPeoples', fn ($sub) => $sub->where('people_id', $entityId));
                });
                break;

            case 'lead':
                $query->where(function ($q) use ($entityId) {
                    $q->whereHas('leads', fn ($sub) => $sub->where('lead_id', $entityId));
                    // leads don’t have a mention relation (if you have one, add it like others)
                });
                break;

            case 'user':
                $query->where(function ($q) use ($entityId) {
                    $q->whereHas('users', fn ($sub) => $sub->where('user_id', $entityId))
                        ->orWhereHas('mentionUsers', fn ($sub) => $sub->where('user_id', $entityId));
                });
                break;

            default:
                return collect(); // invalid entity type
        }

        return $query->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();
        //  return $query->orderBy('created_at', 'desc')->get();
    }

    public static function getNotesForParticipant(string $entityType, int $entityId)
    {
        $query = Note::query()->with(['companies', 'peoples', 'users', 'owner']);

        switch ($entityType) {
            case 'company':
                $query->where('owner_type', 'Company')->where('owner_id', $entityId);
                break;

            case 'people':
                $query->where('owner_type', 'People')->where('owner_id', $entityId);
                break;

            case 'lead':
                $query->where('owner_type', 'Lead')->where('owner_id', $entityId);
                break;

            case 'user':
                $query->where('owner_type', 'User')->where('owner_id', $entityId);
                break;

            default:
                return collect(); // empty if invalid entity type
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public static function getTimelineForEntity(string $entityType, int $entityId)
    {
        $query = Timeline::query()->with('creator');

        switch (strtolower($entityType)) {
            case 'company':
                $query->where('owner_type', 'company')->where('owner_id', $entityId);
                break;

            case 'people':
                $query->where('owner_type', 'people')->where('owner_id', $entityId);
                break;

            case 'lead':
                $query->where('owner_type', 'lead')->where('owner_id', $entityId);
                break;

            case 'user':
                $query->where('owner_type', 'user')->where('owner_id', $entityId);
                break;

            default:
                return collect(); // empty collection if invalid type
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public static function applyTimelineFilters($logged_activities, $notes, $timelineEntries, $filters = [])
    {
        $now = now();

        // Extract filters
        $filterRange = $filters['filter_range'] ?? 'all';
        $activityTypeId = $filters['activity_type_id'] ?? 'all';
        $userId = $filters['user_id'] ?? 'all';

        // Range Filter (7, 30, 90 days)
        if ($filterRange !== 'all') {
            $days = intval($filterRange);
            if (in_array($days, [7, 30, 90])) {
                $logged_activities = $logged_activities->filter(function ($a) use ($now, $days) {
                    return $a->timestamp >= $now->copy()->subDays($days);
                });
                $notes = $notes->filter(function ($n) use ($now, $days) {
                    return $n->timestamp >= $now->copy()->subDays($days);
                });
                $timelineEntries = $timelineEntries->filter(function ($t) use ($now, $days) {
                    return $t->timestamp >= $now->copy()->subDays($days);
                });
            }
        }

        // Activity Type Filter
        if ($activityTypeId !== 'all') {
            // Show only matching activities
            $logged_activities = $logged_activities->filter(function ($a) use ($activityTypeId) {
                return isset($a->activity_type_id) && $a->activity_type_id == $activityTypeId;
            });

            // Hide notes and timeline entries completely
            $notes = collect([]);
            $timelineEntries = collect([]);
        }

        // User Filter
        if ($userId !== 'all') {
            $logged_activities = $logged_activities->filter(function ($a) use ($userId) {
                return isset($a->user_id) && $a->user_id == $userId;
            });

            $notes = $notes->filter(function ($n) use ($userId) {
                return isset($n->user_id) && $n->user_id == $userId;
            });

            $timelineEntries = $timelineEntries->filter(function ($t) use ($userId) {
                return isset($t->user_id) && $t->user_id == $userId;
            });
        }

        // Return filtered collections
        return [
            'logged_activities' => $logged_activities->values(),
            'notes' => $notes->values(),
            'timelineEntries' => $timelineEntries->values(),
        ];
    }

    public static function applySaleActivityFilters($allactivities, $filters = [])
    {
        $now = now();

        // Extract filters
        $filterRange = $filters['filter_range'] ?? 'all';
        $activityTypeId = $filters['activity_type_id'] ?? 'all';
        $statusFilter = $filters['status'] ?? 'all';

        // Range Filter (7, 30, 90 days)
        if ($filterRange !== 'all') {
            $days = intval($filterRange);
            if (in_array($days, [7, 30, 90])) {
                $allactivities = $allactivities->filter(function ($a) use ($now, $days) {
                    return $a->timestamp >= $now->copy()->subDays($days);
                });
            }
        }

        // Status Filter (all / logged / scheduled)
        if ($statusFilter !== 'all') {
            $allactivities = $allactivities->filter(function ($a) use ($statusFilter) {
                return isset($a->status) && strtolower($a->status) === strtolower($statusFilter);
            });
        }

        // Activity Type Filter
        if ($activityTypeId !== 'all') {
            // Show only matching activities
            $allactivities = $allactivities->filter(function ($a) use ($activityTypeId) {
                return isset($a->activity_type_id) && $a->activity_type_id == $activityTypeId;
            });
        }

        // Return filtered collections
        return [
            'allactivities' => $allactivities->values(),
        ];
    }

    public static function applySaleTaskFilters($alltasks, $filters = [])
    {
        $now = now();

        // Extract filters
        $filterRange = $filters['filter_range'] ?? 'all';
        $statusFilter = $filters['status'] ?? 'all';

        // --- Range Filter (7, 30, 90 days) ---
        if ($filterRange !== 'all') {
            $days = intval($filterRange);
            if (in_array($days, [7, 30, 90])) {
                $alltasks = $alltasks->filter(function ($task) use ($now, $days) {
                    return isset($task->created_at) && $task->created_at >= $now->copy()->subDays($days);
                });
            }
        }

        // --- Status Filter (completed / uncompleted / all) ---
        if ($statusFilter !== 'all') {
            if ($statusFilter === 'completed') {
                $alltasks = $alltasks->filter(function ($task) {
                    return isset($task->completed_user_id) && ! is_null($task->completed_user_id);
                });
            } elseif ($statusFilter === 'uncompleted') {
                $alltasks = $alltasks->filter(function ($task) {
                    return ! isset($task->completed_user_id) || is_null($task->completed_user_id);
                });
            }
        }

        return [
            'alltasks' => $alltasks->values(),
        ];
    }

    public static function applySaleTimelineFilters($logged_activities, $notes, $timelineEntries, $milestones, $filters = [])
    {
        $now = now();

        // Extract filters
        $filterRange = $filters['filter_range'] ?? 'all';
        $activityTypeId = $filters['activity_type_id'] ?? 'all';
        $statusFilter = $filters['status'] ?? 'all';
        $typeFilter = $filters['type'] ?? 'all';
        $userId = $filters['user_id'] ?? 'all';

        // RANGE FILTER (7, 30, 90 DAYS)
        if ($filterRange !== 'all') {
            $days = intval($filterRange);
            if (in_array($days, [7, 30, 90])) {
                $logged_activities = $logged_activities->filter(fn ($a) => $a->timestamp >= $now->copy()->subDays($days));
                $notes = $notes->filter(fn ($n) => $n->timestamp >= $now->copy()->subDays($days));
                $timelineEntries = $timelineEntries->filter(fn ($t) => $t->timestamp >= $now->copy()->subDays($days));
                $milestones = $milestones->filter(fn ($m) => $m->timestamp >= $now->copy()->subDays($days));
            }
        }

        // STATUS FILTER (all/logged/scheduled)
        if ($statusFilter !== 'all') {
            $logged_activities = $logged_activities->filter(function ($a) use ($statusFilter) {
                return isset($a->status) && strtolower($a->status) === strtolower($statusFilter);
            });
        }

        // ACTIVITY TYPE FILTER
        if ($activityTypeId !== 'all') {
            $logged_activities = $logged_activities->filter(function ($a) use ($activityTypeId) {
                return isset($a->activity_type_id) && $a->activity_type_id == $activityTypeId;
            });

            // Hide other types if user is filtering by activity type
            $notes = collect([]);
            $timelineEntries = collect([]);
            $milestones = collect([]);
        }

        // USER FILTER
        if ($userId !== 'all') {
            $logged_activities = $logged_activities->filter(fn ($a) => isset($a->user_id) && $a->user_id == $userId);
            $notes = $notes->filter(fn ($n) => isset($n->user_id) && $n->user_id == $userId);
            $timelineEntries = $timelineEntries->filter(fn ($t) => isset($t->user_id) && $t->user_id == $userId);
        }

        // TYPE FILTER (activity / note / timeline / milestone / all)
        if ($typeFilter !== 'all') {
            if ($typeFilter === 'activities') {
                $notes = collect([]);
                $timelineEntries = collect([]);
                $milestones = collect([]);
            } elseif ($typeFilter === 'notes') {
                $logged_activities = collect([]);
                $timelineEntries = collect([]);
                $milestones = collect([]);
            } elseif ($typeFilter === 'updates') {
                $logged_activities = collect([]);
                $notes = collect([]);
                $milestones = collect([]);
            } elseif ($typeFilter === 'milestone') {
                $logged_activities = collect([]);
                $notes = collect([]);
                $timelineEntries = collect([]);
            }
        }

        // RETURN FILTERED COLLECTIONS
        return [
            'logged_activities' => $logged_activities->values(),
            'notes' => $notes->values(),
            'timelineEntries' => $timelineEntries->values(),
            'milestones' => $milestones->values(),
        ];
    }
}
