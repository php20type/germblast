<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarehouseTask extends Model
{
    use SoftDeletes;

    protected $table = 'warehouse_tasks';

    protected $fillable = [
        'title',
        'description',
        'supplier',
        'unit_of_measure',
        'reorder_point',
        'reorder_quantity',
        'frequency',
        'form_type',
        'vehicle_id',
        'last_performed_by',
        'last_performed_on',
        'notes',
        'due',
    ];

    protected $casts = [
        'due' => 'boolean',
        'frequency' => 'integer',
        'form_type' => 'integer',
    ];

    // Mappings for Integer states
    public static $frequencies = [
        1 => 'Daily',
        2 => 'Twice/Week',
        3 => 'Weekly',
        4 => 'Monthly',
        5 => 'Quarterly',
    ];

    public static $formTypes = [
        1 => 'Notes Only',
        2 => 'Notes & Data',
        3 => 'Vehicle Form',
        4 => 'Trailer Form',
        5 => 'Inventory Form',
    ];

    protected $appends = [
        'frequency_text',
        'form_type_text',
    ];

    // Helper to get string representatives
    public function getFrequencyTextAttribute()
    {
        return self::$frequencies[$this->frequency] ?? 'Daily';
    }

    public function getFormTypeTextAttribute()
    {
        return self::$formTypes[$this->form_type] ?? 'Notes Only';
    }

    /**
     * Get the vehicle associated with the task.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
