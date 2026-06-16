<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryReportController extends Controller
{
    public function index()
    {
        $items = [
            [
                'name' => 'Coolers',
                'report_date' => '07/25/24',
                'inventory_val' => '7.00',
                'reorder_point_val' => '',
                'unit' => 'Eaches',
                'actions' => '',
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => '',
                'details' => '',
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Microfibers Black',
                'report_date' => '10/04/23',
                'inventory_val' => '999.99',
                'reorder_point_val' => '',
                'unit' => 'Eaches',
                'actions' => '',
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => '',
                'details' => '',
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Trough',
                'report_date' => '09/03/24',
                'inventory_val' => '7.00',
                'reorder_point_val' => '',
                'unit' => 'Eaches',
                'actions' => '',
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => '',
                'details' => '',
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Day Duties - Testing',
                'report_date' => '05/21/26',
                'inventory_val' => '',
                'reorder_point_val' => '0.00',
                'unit' => '',
                'actions' => 'Please be sure you have an additional 0 on order',
                'warning' => true,
                'office' => 'Lubbock, TX',
                'supplier' => '',
                'details' => '',
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Def',
                'report_date' => '11/13/24',
                'inventory_val' => '1.00',
                'reorder_point_val' => '0.00',
                'unit' => 'Jugs',
                'actions' => '',
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => '',
                'details' => '',
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Gray Dust Heads',
                'report_date' => '06/22/22',
                'inventory_val' => '1.00',
                'reorder_point_val' => '0.00',
                'unit' => 'Eaches',
                'actions' => '',
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => '',
                'details' => '',
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Gray Mop Heads',
                'report_date' => '08/22/22',
                'inventory_val' => '5.00',
                'reorder_point_val' => '0.00',
                'unit' => 'Eaches',
                'actions' => '',
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => '',
                'details' => '',
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Mop Buckets',
                'report_date' => '08/22/22',
                'inventory_val' => '4.00',
                'reorder_point_val' => '0.00',
                'unit' => 'Eaches',
                'actions' => '',
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => '',
                'details' => '',
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Shoe covers',
                'report_date' => '09/11/24',
                'inventory_val' => '1.00',
                'reorder_point_val' => '1.00',
                'unit' => 'Cases',
                'actions' => '',
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => '',
                'details' => '',
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Uniform Shirts - 2XL',
                'report_date' => '11/13/24',
                'inventory_val' => '2.00',
                'reorder_point_val' => '2.00',
                'unit' => '',
                'actions' => '',
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => '',
                'details' => '',
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Uniform Shirts - 3XL',
                'report_date' => '11/13/24',
                'inventory_val' => '0.00',
                'reorder_point_val' => '2.00',
                'unit' => 'Shirts',
                'actions' => 'Please be sure you have an additional 2 Shirts on order',
                'warning' => true,
                'office' => 'Lubbock, TX',
                'supplier' => '',
                'details' => '',
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Uniform Shirts - 4XL',
                'report_date' => '11/13/24',
                'inventory_val' => '1.00',
                'reorder_point_val' => '2.00',
                'unit' => 'Shirts',
                'actions' => 'Please be sure you have an additional 2 Shirts on order',
                'warning' => true,
                'office' => 'Lubbock, TX',
                'supplier' => '',
                'details' => '',
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Uniform Shirts - Large',
                'report_date' => '11/13/24',
                'inventory_val' => '2.00',
                'reorder_point_val' => '2.00',
                'unit' => 'Shirts',
                'actions' => '',
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => '',
                'details' => '',
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Uniform Shirts - Medium',
                'report_date' => '11/13/24',
                'inventory_val' => '2.00',
                'reorder_point_val' => '2.00',
                'unit' => 'Shirts',
                'actions' => '',
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => '',
                'details' => '',
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Uniform Shirts - Small',
                'report_date' => '11/13/24',
                'inventory_val' => '5.00',
                'reorder_point_val' => '2.00',
                'unit' => 'Shirts',
                'actions' => '',
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => '',
                'details' => '',
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Uniform Shirts - XL',
                'report_date' => '11/13/24',
                'inventory_val' => '2.00',
                'reorder_point_val' => '2.00',
                'unit' => 'Shirts',
                'actions' => '',
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => '',
                'details' => '',
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Uniform Shirts - XS',
                'report_date' => '11/13/24',
                'inventory_val' => '9.00',
                'reorder_point_val' => '2.00',
                'unit' => 'Shirts',
                'actions' => '',
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => '',
                'details' => '',
                'notes' => 'Write notes here'
            ],
            [
                'name' => '3M Particulate Filters',
                'report_date' => '11/13/24',
                'inventory_val' => '3.00',
                'reorder_point_val' => '10.00',
                'unit' => 'Boxes',
                'actions' => 'Please be sure you have an additional 20 Boxes on order',
                'warning' => true,
                'office' => 'Lubbock, TX',
                'supplier' => '',
                'details' => '',
                'notes' => 'Write notes here'
            ],
        ];

        return view('admin.reports.inventory', compact('items'));
    }
}
