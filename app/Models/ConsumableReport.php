<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumableReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'user_id',
        'reported_at',
        'status',
        'micro_pre',
        'micro_post',
        'disp_micro_pre',
        'disp_micro_post',
        'halo_pre',
        'halo_post',
        'opti_pre',
        'opti_post',
        'd2_pre',
        'd2_post',
        'oxi_pre',
        'oxi_post',
        'shld_pre',
        'shld_post',
        'sterl_pre',
        'sterl_post',
        'atp_pre',
        'atp_post',
        'gloves_pre',
        'gloves_post',
        'water_pre',
        'water_post',
        'rinse_pre',
        'rinse_post',
        'wash_pre',
        'wash_post',
        'rust_pre',
        'rust_post',
    ];

    protected $casts = [
        'reported_at' => 'datetime',
        'micro_pre' => 'decimal:2',
        'micro_post' => 'decimal:2',
        'disp_micro_pre' => 'decimal:2',
        'disp_micro_post' => 'decimal:2',
        'halo_pre' => 'decimal:2',
        'halo_post' => 'decimal:2',
        'opti_pre' => 'decimal:2',
        'opti_post' => 'decimal:2',
        'd2_pre' => 'decimal:2',
        'd2_post' => 'decimal:2',
        'oxi_pre' => 'decimal:2',
        'oxi_post' => 'decimal:2',
        'shld_pre' => 'decimal:2',
        'shld_post' => 'decimal:2',
        'sterl_pre' => 'decimal:2',
        'sterl_post' => 'decimal:2',
        'atp_pre' => 'decimal:2',
        'atp_post' => 'decimal:2',
        'gloves_pre' => 'decimal:2',
        'gloves_post' => 'decimal:2',
        'water_pre' => 'decimal:2',
        'water_post' => 'decimal:2',
        'rinse_pre' => 'decimal:2',
        'rinse_post' => 'decimal:2',
        'wash_pre' => 'decimal:2',
        'wash_post' => 'decimal:2',
        'rust_pre' => 'decimal:2',
        'rust_post' => 'decimal:2',
    ];

    protected $with = ['company', 'leader'];

    /**
     * Get the company associated with this consumable report.
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * Get the leader (user) who submitted this consumable report.
     */
    public function leader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
