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
        'is_assigned',
    ];

    protected function casts(): array
    {
        return [
            'is_assigned' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS CONSTANTS
    |--------------------------------------------------------------------------
    */

    public const STATUS_NEW = 'new';
    public const STATUS_READY = 'ready';
    public const STATUS_DIRTY = 'dirty';
    public const STATUS_BROKEN = 'broken';
    public const STATUS_LOST = 'lost';
    public const STATUS_DECOMMISSIONED = 'decommissioned';

    public static function statuses(): array
    {
        return [
            self::STATUS_NEW,
            self::STATUS_READY,
            self::STATUS_DIRTY,
            self::STATUS_BROKEN,
            self::STATUS_LOST,
            self::STATUS_DECOMMISSIONED,
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

    /*
    |--------------------------------------------------------------------------
    | STATUS HELPERS
    |--------------------------------------------------------------------------
    */

    public function isNew(): bool
    {
        return $this->status === self::STATUS_NEW;
    }

    public function isReady(): bool
    {
        return $this->status === self::STATUS_READY;
    }

    public function isDirtyStatus(): bool
    {
        return $this->status === self::STATUS_DIRTY;
    }

    public function isBroken(): bool
    {
        return $this->status === self::STATUS_BROKEN;
    }

    public function isLost(): bool
    {
        return $this->status === self::STATUS_LOST;
    }

    public function isDecommissioned(): bool
    {
        return $this->status === self::STATUS_DECOMMISSIONED;
    }

    public function isInUse(): bool
    {
        return (bool) $this->is_assigned;
    }

    public function getAvailableStatusOptions(): array
    {
        switch ($this->status) {

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

            default:
                return [];
        }
    }

    /**
     * Check whether a transition from the current status to $newStatus is allowed.
     * Used by the controller to enforce server-side transition rules.
     */
    public function canTransitionTo(string $newStatus): bool
    {
        return in_array($newStatus, $this->getAvailableStatusOptions(), true);
    }
}
