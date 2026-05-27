<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';

    protected $fillable = [
        'barcode',
        'serial_number',
        'type_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'integer',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS CONSTANTS
    |--------------------------------------------------------------------------
    */

    public const STATUS_NEW = 1;
    public const STATUS_READY = 2;
    public const STATUS_DIRTY = 3;
    public const STATUS_BROKEN = 4;
    public const STATUS_LOST = 5;
    public const STATUS_DECOMMISSIONED = 6;
    public const STATUS_ASSIGNED = 7;

    public static function statuses(): array
    {
        return [
            self::STATUS_NEW,
            self::STATUS_READY,
            self::STATUS_DIRTY,
            self::STATUS_BROKEN,
            self::STATUS_LOST,
            self::STATUS_DECOMMISSIONED,
            self::STATUS_ASSIGNED,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function type()
    {
        return $this->belongsTo(EquipmentManagementType::class, 'type_id');
    }

    public function statusLogs()
    {
        return $this->hasMany(EquipmentStatusLog::class, 'equipment_id');
    }

    public function slots()
    {
        return $this->belongsToMany(ServiceOrderSlot::class, 'service_order_slot_equipments', 'equipment_id', 'service_order_slot_id')
                    ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS HELPERS
    |--------------------------------------------------------------------------
    */

    public function isNew(): bool
    {
        return (int) $this->status === self::STATUS_NEW;
    }

    public function isReady(): bool
    {
        return (int) $this->status === self::STATUS_READY;
    }

    public function isDirtyStatus(): bool
    {
        return (int) $this->status === self::STATUS_DIRTY;
    }

    public function isBroken(): bool
    {
        return (int) $this->status === self::STATUS_BROKEN;
    }

    public function isLost(): bool
    {
        return (int) $this->status === self::STATUS_LOST;
    }

    public function isDecommissioned(): bool
    {
        return (int) $this->status === self::STATUS_DECOMMISSIONED;
    }

    public function isAssigned(): bool
    {
        return (int) $this->status === self::STATUS_ASSIGNED || $this->slots()->exists();
    }

    public function getAvailableStatusOptions(): array
    {
        switch ((int) $this->status) {

            case self::STATUS_NEW:
                return [self::STATUS_READY];

            case self::STATUS_READY:
                return [
                    self::STATUS_LOST,
                    self::STATUS_BROKEN,
                    self::STATUS_DIRTY,
                ];

            case self::STATUS_DIRTY:
                return [self::STATUS_READY];

            case self::STATUS_BROKEN:
                return [
                    self::STATUS_DIRTY,
                    self::STATUS_BROKEN,
                    self::STATUS_LOST,
                    self::STATUS_DECOMMISSIONED,
                ];

            case self::STATUS_LOST:
                return [
                    self::STATUS_DIRTY,
                    self::STATUS_BROKEN,
                    self::STATUS_LOST,
                    self::STATUS_DECOMMISSIONED,
                ];

            case self::STATUS_DECOMMISSIONED:
                return [
                    self::STATUS_DIRTY,
                    self::STATUS_BROKEN,
                    self::STATUS_LOST,
                ];

            case self::STATUS_ASSIGNED:
                return [
                    self::STATUS_DIRTY,
                    self::STATUS_BROKEN,
                    self::STATUS_LOST,
                ];

            default:
                return [];
        }
    }

    /**
     * Check whether a transition from the current status to $newStatus is allowed.
     * Used by the controller to enforce server-side transition rules.
     */
    public function canTransitionTo($newStatus): bool
    {
        if (is_string($newStatus) && !is_numeric($newStatus)) {
            $mapped = array_search($newStatus, config('mapping.equipment_status', []));
            if ($mapped !== false) {
                $newStatus = $mapped;
            }
        }
        return in_array((int) $newStatus, $this->getAvailableStatusOptions(), true);
    }
}
