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
            1 => 'Customer',
            2 => 'Technician',
            3 => 'Warehouse Technician',
            4 => 'Training Supervisor',
            5 => 'Supervisor',
            6 => 'Job Manager',
            7 => 'Warehouse Manager',
            8 => 'Sales Representative',
            9 => 'Sales Team',
            10 => 'Sales Manager',
            11 => 'Assistant Operations Manager',
            12 => 'Operations Manager',
            13 => 'Regional Operations Manager',
            14 => 'Field Epidemiology Team',
            15 => 'Corporate Team',
            16 => 'Senior Corporate',
            17 => 'Super Admin',
        ];

        foreach ($roles as $id => $name) {
            Role::updateOrCreate(
                ['id' => $id],
                ['name' => $name, 'guard_name' => 'web']
            );
        }
    }
}
