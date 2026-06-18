<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $table = 'inventory_items';

    protected $fillable = [
        'name',
        'report_date',
        'inventory_val',
        'reorder_point_val',
        'unit',
        'actions',
        'warning',
        'office',
        'supplier',
        'details',
        'notes',
    ];

    protected $casts = [
        'report_date' => 'date',
        'inventory_val' => 'decimal:2',
        'reorder_point_val' => 'decimal:2',
        'warning' => 'boolean',
    ];
}
