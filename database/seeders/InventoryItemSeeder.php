<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryItem;
use Carbon\Carbon;

class InventoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => 'Coolers',
                'report_date' => '2024-07-25',
                'inventory_val' => 7.00,
                'reorder_point_val' => null,
                'unit' => 'Eaches',
                'actions' => null,
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => null,
                'details' => null,
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Microfibers Black',
                'report_date' => '2023-10-04',
                'inventory_val' => 999.99,
                'reorder_point_val' => null,
                'unit' => 'Eaches',
                'actions' => null,
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => null,
                'details' => null,
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Trough',
                'report_date' => '2024-09-03',
                'inventory_val' => 7.00,
                'reorder_point_val' => null,
                'unit' => 'Eaches',
                'actions' => null,
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => null,
                'details' => null,
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Day Duties - Testing',
                'report_date' => '2026-05-21',
                'inventory_val' => null,
                'reorder_point_val' => 0.00,
                'unit' => null,
                'actions' => 'Please be sure you have an additional 0 on order',
                'warning' => true,
                'office' => 'Lubbock, TX',
                'supplier' => null,
                'details' => null,
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Def',
                'report_date' => '2024-11-13',
                'inventory_val' => 1.00,
                'reorder_point_val' => 0.00,
                'unit' => 'Jugs',
                'actions' => null,
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => null,
                'details' => null,
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Gray Dust Heads',
                'report_date' => '2022-06-22',
                'inventory_val' => 1.00,
                'reorder_point_val' => 0.00,
                'unit' => 'Eaches',
                'actions' => null,
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => null,
                'details' => null,
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Gray Mop Heads',
                'report_date' => '2022-08-22',
                'inventory_val' => 5.00,
                'reorder_point_val' => 0.00,
                'unit' => 'Eaches',
                'actions' => null,
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => null,
                'details' => null,
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Mop Buckets',
                'report_date' => '2022-08-22',
                'inventory_val' => 4.00,
                'reorder_point_val' => 0.00,
                'unit' => 'Eaches',
                'actions' => null,
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => null,
                'details' => null,
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Shoe covers',
                'report_date' => '2024-09-11',
                'inventory_val' => 1.00,
                'reorder_point_val' => 1.00,
                'unit' => 'Cases',
                'actions' => null,
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => null,
                'details' => null,
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Uniform Shirts - 2XL',
                'report_date' => '2024-11-13',
                'inventory_val' => 2.00,
                'reorder_point_val' => 2.00,
                'unit' => null,
                'actions' => null,
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => null,
                'details' => null,
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Uniform Shirts - 3XL',
                'report_date' => '2024-11-13',
                'inventory_val' => 0.00,
                'reorder_point_val' => 2.00,
                'unit' => 'Shirts',
                'actions' => 'Please be sure you have an additional 2 Shirts on order',
                'warning' => true,
                'office' => 'Lubbock, TX',
                'supplier' => null,
                'details' => null,
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Uniform Shirts - 4XL',
                'report_date' => '2024-11-13',
                'inventory_val' => 1.00,
                'reorder_point_val' => 2.00,
                'unit' => 'Shirts',
                'actions' => 'Please be sure you have an additional 2 Shirts on order',
                'warning' => true,
                'office' => 'Lubbock, TX',
                'supplier' => null,
                'details' => null,
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Uniform Shirts - Large',
                'report_date' => '2024-11-13',
                'inventory_val' => 2.00,
                'reorder_point_val' => 2.00,
                'unit' => 'Shirts',
                'actions' => null,
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => null,
                'details' => null,
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Uniform Shirts - Medium',
                'report_date' => '2024-11-13',
                'inventory_val' => 2.00,
                'reorder_point_val' => 2.00,
                'unit' => 'Shirts',
                'actions' => null,
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => null,
                'details' => null,
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Uniform Shirts - Small',
                'report_date' => '2024-11-13',
                'inventory_val' => 5.00,
                'reorder_point_val' => 2.00,
                'unit' => 'Shirts',
                'actions' => null,
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => null,
                'details' => null,
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Uniform Shirts - XL',
                'report_date' => '2024-11-13',
                'inventory_val' => 2.00,
                'reorder_point_val' => 2.00,
                'unit' => 'Shirts',
                'actions' => null,
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => null,
                'details' => null,
                'notes' => 'Write notes here'
            ],
            [
                'name' => 'Uniform Shirts - XS',
                'report_date' => '2024-11-13',
                'inventory_val' => 9.00,
                'reorder_point_val' => 2.00,
                'unit' => 'Shirts',
                'actions' => null,
                'warning' => false,
                'office' => 'Lubbock, TX',
                'supplier' => null,
                'details' => null,
                'notes' => 'Write notes here'
            ],
            [
                'name' => '3M Particulate Filters',
                'report_date' => '2024-11-13',
                'inventory_val' => 3.00,
                'reorder_point_val' => 10.00,
                'unit' => 'Boxes',
                'actions' => 'Please be sure you have an additional 20 Boxes on order',
                'warning' => true,
                'office' => 'Lubbock, TX',
                'supplier' => null,
                'details' => null,
                'notes' => 'Write notes here'
            ],
        ];

        foreach ($items as $item) {
            InventoryItem::create($item);
        }
    }
}
