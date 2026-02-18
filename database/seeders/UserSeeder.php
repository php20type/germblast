<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // ========================
        // Super Admin
        // ========================
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@germblast.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin', // your column in users table
            ]
        );

        $superAdmin->assignRole('super_admin');


        // ========================
        // Sales Representative
        // ========================
        $salesRep = User::updateOrCreate(
            ['email' => 'salesrep@germblast.com'],
            [
                'name' => 'Sales Representative',
                'password' => Hash::make('password'),
                'role' => 'sales_representative',
            ]
        );

        $salesRep->assignRole('sales_representative');


        // ========================
        // Sales Manager
        // ========================
        $salesManager = User::updateOrCreate(
            ['email' => 'salesmanager@germblast.com'],
            [
                'name' => 'Sales Manager',
                'password' => Hash::make('password'),
                'role' => 'sales_manager',
            ]
        );

        $salesManager->assignRole('sales_manager');

        // ========================
        // Sales Team
        // ========================
        $salesTeam = User::updateOrCreate(
            ['email' => 'salesteam@germblast.com'],
            [
                'name' => 'Sales Team',
                'password' => Hash::make('password'),
                'role' => 'sales_team',
            ]
        );

        $salesTeam->assignRole('sales_team');

    }
}
