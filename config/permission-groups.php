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
        'service.dashboard.edit',
        'service.fulfill_order.view',
        'service.fulfill_order.edit',
    ],

    'HR Module' => [
        'hr.view',
        'employee.view',
        'employee.edit',
        'time_off_request.view',
        'time_off_request.edit',
        'team_praise.view',
        'team_praise.add',
        'gb_reward.view',
        'gb_reward.add',
        'anonymous_feedback.view',
        'anonymous_feedback.add',
    ],

    'Corporate Tools Module' => [
        'corporate_tools.view',
        'change_control.view',
        'change_control.add',
        'change_control.edit',
        'consumable_report.view',
        'consumable_report.add',
        'consumable_report.edit',
        'expense_report.view',
        'expense_report.add',
        'expense_report.edit',
        'inventory_reporting.view',
        'inventory_reporting.add',
        'inventory_reporting.edit',
        'job_profitability.view',
        'office_duties.view',
        'office_duties.add',
        'office_duties.edit',
    ],

];
