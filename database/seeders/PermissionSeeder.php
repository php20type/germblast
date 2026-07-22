<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            /*
            |--------------------------------------------------
            | Company Module
            |--------------------------------------------------
            */
            1 => 'company.create',
            2  => 'company.delete',

            3  => 'company.list.all.view',
            4  => 'company.list.my.view',

            5  => 'company.detail.view',
            6  => 'company.detail.edit',

            7  => 'company.dashboard.view',
            8  => 'company.dashboard.edit',


            /*
            |--------------------------------------------------
            | People Module
            |--------------------------------------------------
            */
            9 => 'people.create',
            10 => 'people.delete',

            11 => 'people.list.all.view',
            12 => 'people.list.my.view',
            13 => 'people.list.animal_care.view',
            14 => 'people.list.marketing_contacts.view',
            15 => 'people.list.sequence_healthcare.view',

            16 => 'people.detail.view',
            17 => 'people.detail.edit',


            /*
            |--------------------------------------------------
            | Lead Module
            |--------------------------------------------------
            */
            18 => 'lead.create',
            19 => 'lead.delete',

            20 => 'lead.list.all.view',
            21 => 'lead.list.my.view',
            22 => 'lead.list.hot.view',
            23 => 'lead.list.added_this_week.view',
            24 => 'lead.list.closing_this_week.view',
            25 => 'lead.list.open.view',
            26 => 'lead.list.watching.view',

            27 => 'lead.detail.view',
            28 => 'lead.detail.edit',

            /*
            |--------------------------------------------------
            | Survey / Pricing Proposal
            |--------------------------------------------------
            */
            29 => 'survey.proposal.view',
            30 => 'survey.proposal.create',
            31 => 'survey.proposal.edit',
            32 => 'survey.proposal.delete',

            33 => 'pricing.proposal.view',
            34 => 'pricing.proposal.create',
            35 => 'pricing.proposal.edit',
            36 => 'pricing.proposal.delete',

            /*
            |--------------------------------------------------
            | Service Module (Fulfill Order, Dashboard)
            |--------------------------------------------------
            */
            37 => 'service.dashboard.view',
            38 => 'service.dashboard.edit',
            39 => 'service.fulfill_order.view',
            40 => 'service.fulfill_order.edit',

            /*
            |--------------------------------------------------
            | HR Module
            |--------------------------------------------------
            */
            41 => 'hr.view',
            42 => 'employee.view',
            43 => 'employee.edit',
            44 => 'time_off_request.view',
            45 => 'time_off_request.edit',
            46 => 'team_praise.view',
            47 => 'team_praise.add',
            48 => 'gb_reward.view',
            49 => 'gb_reward.add',
            50 => 'anonymous_feedback.view',
            51 => 'anonymous_feedback.add',

            /*
            |--------------------------------------------------
            | Corporate Tools Module
            |--------------------------------------------------
            */
            52 => 'corporate_tools.view',
            53 => 'change_control.view',
            54 => 'change_control.add',
            55 => 'change_control.edit',
            56 => 'consumable_report.view',
            57 => 'consumable_report.add',
            58 => 'consumable_report.edit',
            59 => 'expense_report.view',
            60 => 'expense_report.add',
            61 => 'expense_report.edit',
            62 => 'inventory_reporting.view',
            63 => 'inventory_reporting.add',
            64 => 'inventory_reporting.edit',
            65 => 'job_profitability.view',
            66 => 'office_duties.view',
            67 => 'office_duties.add',
            68 => 'office_duties.edit',

            /*
            |--------------------------------------------------
            | Operations Module
            |--------------------------------------------------
            */
            69 => 'operations.view',
            70 => 'all_schedules.view',
            71 => 'business_failures.view',
            72 => 'business_failures.add',
            73 => 'driver_report.view',
            74 => 'driver_report.edit',
            75 => 'equipment_manager.view',
            76 => 'equipment_manager.add',
            77 => 'scheduling_calendar.view',
            78 => 'team_availability.view',
            79 => 'vehicle_planning.view',
            80 => 'vehicle_planning.add',
            81 => 'warehouse.view',
            82 => 'warehouse.add',
            83 => 'warehouse_calendar.view',
            84 => 'warehouse_calendar.edit',
            85 => 'training.view',
            86 => 'training.add',
            87 => 'training.edit',
        ];

        foreach ($permissions as $id => $name) {
            Permission::updateOrCreate(
                ['id' => $id],
                ['name' => $name, 'guard_name' => 'web']
            );
        }

        // Clean up outdated permissions that are no longer in the list
        Permission::whereIn('name', ['time_off_request.add', 'gb_reward.edit'])->delete();
        Permission::whereNotIn('id', array_keys($permissions))->delete();
    }
}
