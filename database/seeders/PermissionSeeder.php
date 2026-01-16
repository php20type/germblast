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
            | Company Module (1–15)
            |--------------------------------------------------
            */
            1  => 'company.view',
            2  => 'company.my.view',
            3  => 'company.create',
            4  => 'company.update',
            5  => 'company.delete',

            6  => 'company.location.manage',
            7  => 'company.people.manage',
            8  => 'company.tag.manage',
            9  => 'company.file.manage',

            10 => 'company.task.manage',
            11 => 'company.activity.manage',

            12 => 'company.dashboard.view',
            13 => 'company.iaq.manage',
            14 => 'company.biological.manage',
            15 => 'company.survey.manage',
            16 => 'company.water.manage',

            /*
            |--------------------------------------------------
            | People Module (17–30)
            |--------------------------------------------------
            */
            17 => 'people.view',
            18 => 'people.create',
            19 => 'people.update',
            20 => 'people.delete',

            21 => 'people.my.view',
            22 => 'people.animal_care.view',
            23 => 'people.marketing_contacts.view',
            24 => 'people.sequence_healthcare.view',

            25 => 'people.task.manage',
            26 => 'people.activity.manage',

            27 => 'people.company.manage',
            28 => 'people.tag.manage',
            29 => 'people.file.manage',
            30 => 'people.field.manage',

            /*
            |--------------------------------------------------
            | Lead Module (31–50)
            |--------------------------------------------------
            */
            31 => 'lead.view',
            32 => 'lead.create',
            33 => 'lead.update',
            34 => 'lead.delete',

            35 => 'lead.my.view',
            36 => 'lead.hot.view',
            37 => 'lead.added_this_week.view',
            38 => 'lead.closing_this_week.view',
            39 => 'lead.open.view',
            40 => 'lead.watching.view',

            41 => 'lead.task.manage',
            42 => 'lead.activity.manage',

            43 => 'lead.tag.manage',
            44 => 'lead.file.manage',
            45 => 'lead.field.manage',
            46 => 'lead.product.manage',

            47 => 'lead.forecasting.manage',
            48 => 'lead.ajax.update',

            49 => 'lead.stage.initial.schedule',
            50 => 'lead.stage.initial.complete',
            51 => 'lead.stage.initial.reopen',
            52 => 'lead.stage.initial.reset',

            53 => 'lead.stage.site_survey.schedule',
            54 => 'lead.stage.site_survey.complete',
            55 => 'lead.stage.site_survey.reopen',
            56 => 'lead.stage.site_survey.reset',

            /*
            |--------------------------------------------------
            | Survey / Pricing Proposal (57–70)
            |--------------------------------------------------
            */
            57 => 'survey.proposal.view',
            58 => 'survey.proposal.create',

            59 => 'survey.proposal.facility.view',
            60 => 'survey.proposal.facility.create',
            61 => 'survey.proposal.facility.update',

            62 => 'survey.proposal.equipment.view',
            63 => 'survey.proposal.equipment.create',
            64 => 'survey.proposal.equipment.update',

            65 => 'survey.proposal.pricing.view',
            66 => 'survey.proposal.view.details',
            67 => 'survey.proposal.download',

            68 => 'pricing.proposal.create',
            69 => 'pricing.proposal.update',
            70 => 'pricing.proposal.delete',
        ];

        foreach ($permissions as $id => $name) {
            Permission::updateOrCreate(
                ['id' => $id],
                ['name' => $name, 'guard_name' => 'web']
            );
        }
    }
}
