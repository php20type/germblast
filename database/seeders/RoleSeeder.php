<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            1 => 'super_admin',
            2 => 'technician',
            3 => 'warehouse_technician',
            4 => 'training_supervisor',
            5 => 'supervisor',
            6 => 'job_manager',
            7 => 'warehouse_manager',
            8 => 'sales_representative',
            9 => 'sales_team',
            10 => 'sales_manager',
            11 => 'assistant_operations_manager',
            12 => 'operations_manager',
            13 => 'regional_operations_manager',
            14 => 'field_epidemiology_team',
            15 => 'corporate_team',
            16 => 'senior_corporate',
            17 => 'customer',
            18 => 'hr',
        ];

        foreach ($roles as $id => $name) {
            Role::updateOrCreate(
                ['id' => $id],
                ['name' => $name, 'guard_name' => 'web']
            );
        }
    }
}
