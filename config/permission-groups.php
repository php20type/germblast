<?php

return [

    'Company' => [
        'company.create',
        'company.delete',
        'company.list.all.view',
        'company.list.my.view',
        'company.detail.view',
        'company.detail.edit',
        'company.dashboard.view',
        'company.dashboard.edit',
    ],

    'People' => [
        'people.create',
        'people.delete',
        'people.list.all.view',
        'people.list.my.view',
        'people.list.animal_care.view',
        'people.list.marketing_contacts.view',
        'people.list.sequence_healthcare.view',
        'people.detail.view',
        'people.detail.edit',
    ],

    'Lead' => [
        'lead.create',
        'lead.delete',
        'lead.list.all.view',
        'lead.list.my.view',
        'lead.list.hot.view',
        'lead.list.added_this_week.view',
        'lead.list.closing_this_week.view',
        'lead.list.open.view',
        'lead.list.watching.view',
        'lead.detail.view',
        'lead.detail.edit',
    ],

    'Survey Proposal' => [
        'survey.proposal.view',
        'survey.proposal.create',
        'survey.proposal.edit',
        'survey.proposal.delete',
    ],

    'Pricing Proposal' => [
        'pricing.proposal.view',
        'pricing.proposal.create',
        'pricing.proposal.edit',
        'pricing.proposal.delete',
    ],

    'Service' => [
        'service.dashboard.view',
        'service.fulfill_order.view',
        'service.fulfill_order.edit',
    ],

    'HR Module' => [
        'hr.module.view',
        'hr.module.create',
        'hr.module.edit',
        'hr.module.delete',
    ],

    'Warehouse Module' => [
        'warehouse.module.view',
        'warehouse.module.create',
        'warehouse.module.edit',
        'warehouse.module.delete',
    ],

    'Operations Module' => [
        'operations.module.view',
        'operations.module.create',
        'operations.module.edit',
        'operations.module.delete',
    ],

    'Reports' => [
        'reports.work_report.view',
        'reports.work_report.create',
        'reports.work_report.edit',
        'reports.work_report.delete',

        'reports.expense.view',
        'reports.expense.create',
        'reports.expense.edit',
        'reports.expense.delete',

        'reports.consumable.view',
        'reports.consumable.create',
        'reports.consumable.edit',
        'reports.consumable.delete',

        'reports.job_profitability.view',
        'reports.job_profitability.create',
        'reports.job_profitability.edit',
        'reports.job_profitability.delete',
    ],

];

