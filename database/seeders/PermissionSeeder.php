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
            41 => 'hr.module.view',
            42 => 'hr.module.create',
            43 => 'hr.module.edit',
            44 => 'hr.module.delete',

            /*
            |--------------------------------------------------
            | Warehouse Module
            |--------------------------------------------------
            */
            45 => 'warehouse.module.view',
            46 => 'warehouse.module.create',
            47 => 'warehouse.module.edit',
            48 => 'warehouse.module.delete',

            /*
            |--------------------------------------------------
            | Operations Module
            |--------------------------------------------------
            */
            49 => 'operations.module.view',
            50 => 'operations.module.create',
            51 => 'operations.module.edit',
            52 => 'operations.module.delete',

            /*
            |--------------------------------------------------
            | Reports Module
            |--------------------------------------------------
            */
            53 => 'reports.work_report.view',
            54 => 'reports.work_report.create',
            55 => 'reports.work_report.edit',
            56 => 'reports.work_report.delete',

            57 => 'reports.expense.view',
            58 => 'reports.expense.create',
            59 => 'reports.expense.edit',
            60 => 'reports.expense.delete',

            61 => 'reports.consumable.view',
            62 => 'reports.consumable.create',
            63 => 'reports.consumable.edit',
            64 => 'reports.consumable.delete',

            65 => 'reports.job_profitability.view',
            66 => 'reports.job_profitability.create',
            67 => 'reports.job_profitability.edit',
            68 => 'reports.job_profitability.delete',
        ];

        foreach ($permissions as $id => $name) {
            Permission::updateOrCreate(
                ['id' => $id],
                ['name' => $name, 'guard_name' => 'web']
            );
        }
    }
}
