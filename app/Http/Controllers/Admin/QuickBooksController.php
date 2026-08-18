<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\ServiceOrderInvoice;

class QuickBooksController extends Controller
{
    /**
     * Display the QuickBooks export options.
     */
    public function index()
    {
        return view('admin.corporate-tools.quickbooks.index');
    }

    /**
     * Export Customers / Companies based on date range.
     * Maps to QuickBooks Customer CSV format.
     */
    public function exportCustomers(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date . ' 00:00:00';
        $endDate = $request->end_date . ' 23:59:59';

        $companies = Company::with(['locations.city', 'locations.state', 'companyAddress', 'companyEmail', 'companyPhone', 'industry'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=Customers_Export_" . date('Y_m_d') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'CustomerID', 'Company', 'CustomerName', 'Address1', 'Address2', 
            'City', 'State', 'Zip', 'Phone', 'Email', 'Fax', 'CustomerType', 
            'CostCenter', 'Dept', 'SqFootage', 'PayTerms', 'TaxYN', 'TaxRate'
        ];

        $callback = function() use ($companies, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($companies as $company) {
                $primaryLocation = $company->locations->first();
                
                if ($primaryLocation) {
                    $address1 = trim($primaryLocation->address_1 ?? '');
                    $address2 = trim($primaryLocation->address_2 ?? '');
                    $city = $primaryLocation->city ? $primaryLocation->city->name : '';
                    $state = $primaryLocation->state ? $primaryLocation->state->name : '';
                    $zip = $primaryLocation->zip ?? $company->postalCode ?? '';
                } else {
                    $address1 = '';
                    if ($company->companyAddress && $company->companyAddress->billing_address) {
                        $address1 = $company->companyAddress->billing_address;
                    } elseif ($company->companyAddress && $company->companyAddress->main_address) {
                        $address1 = $company->companyAddress->main_address;
                    } elseif ($company->companyAddress && $company->companyAddress->address) {
                        $address1 = $company->companyAddress->address;
                    }
                    $address2 = '';
                    $city = '';
                    $state = '';
                    $zip = $company->postalCode ?? '';
                }

                $phone = $company->companyPhone ? $company->companyPhone->phone : '';
                $fax = $company->companyPhone ? $company->companyPhone->fax : '';
                $email = $company->companyEmail ? $company->companyEmail->email : '';
                $customerType = $company->industry ? $company->industry->name : '';
                
                $taxYn = ($company->tax_rate && $company->tax_rate > 0) ? 'Tax' : 'Non';
                $taxRateValue = $company->tax_rate ?? 0;
                $taxRate = config('mapping.tax_rates.' . $taxRateValue, $taxRateValue);

                fputcsv($file, [
                    $company->legacy_id ?? $company->id,
                    $company->name,
                    $company->name, // Mapping Company Name to CustomerName as well
                    $address1,
                    $address2, // Address2
                    $city, // City
                    $state, // State
                    $zip, // Zip
                    $phone,
                    $email,
                    $fax,
                    $customerType,
                    '', // CostCenter - Not in DB
                    '', // Dept - Not in DB
                    '', // SqFootage - Not in DB
                    '', // PayTerms - Not in DB
                    $taxYn,
                    $taxRate
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export Invoices based on date range.
     * Maps to QuickBooks Invoice CSV format.
     */
    public function exportInvoices(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $invoices = ServiceOrderInvoice::with([
            'serviceOrder.service.lead.company'
        ])
        ->whereBetween('invoice_date', [$startDate, $endDate])
        ->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=Invoices_Export_" . date('Y_m_d') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'Date', 'CustomerID', 'CustomerName', 'OrderID', 
            'ProductID', 'ProdDesc', 'Qty', 'Price', 'Class', 'PO Number'
        ];

        $productMapping = [
            'GermBlast Disinfection Services' => 'GBDS',
            'GermBlast Response Service' => 'GBRS',
            'GermBlast Response Service under contract' => 'RGB',
            'Service Supplies' => 'SS',
            'COVID Travel Manhours' => 'CTM',
            'COVID Service Manhours' => 'CSM',
            'modified GermBlast Response Service' => 'MGBRS',
            'GermBlast Biological Response Service COVID-19' => 'GBRSC19',
            'GermBlast Flat Fee' => 'GBF',
            'GBS - Flooring' => 'GBSF',
            'GBS-BONA Flooring Service' => 'GBBFS',
            'Discount' => 'DISC',
            'Sales Tax' => 'TAX',
        ];

        $callback = function() use ($invoices, $columns, $productMapping) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($invoices as $invoice) {
                // Fetch company details through the relationships
                $company = null;
                $poNumber = '';
                $orderId = '';
                
                if ($invoice->serviceOrder) {
                    $orderId = $invoice->serviceOrder->order_no ?? $invoice->serviceOrder->id;
                    if ($invoice->serviceOrder->service) {
                        $poNumber = $invoice->serviceOrder->service->po_number ?? '';
                        if ($invoice->serviceOrder->service->lead && $invoice->serviceOrder->service->lead->company) {
                            $company = $invoice->serviceOrder->service->lead->company;
                        }
                    }
                }

                $customerId = $company ? ($company->legacy_id ?? $company->id) : '';
                $customerName = $company ? $company->name : '';
                $date = $invoice->invoice_date ? $invoice->invoice_date->format('Y-m-d') : '';

                // Invoices contain line items array
                $lineItems = $invoice->line_items ?? [];
                
                if (empty($lineItems)) {
                    // Output a row even if no line items exist to represent the invoice
                    fputcsv($file, [
                        $date,
                        $customerId,
                        $customerName,
                        $orderId,
                        '', // ProductID
                        '', // ProdDesc
                        '', // Qty
                        $invoice->total_amount ?? '', // Price
                        '', // Class
                        $poNumber
                    ]);
                } else {
                    // Output one row per line item
                    foreach ($lineItems as $item) {
                        $desc = $item['type'] ?? ($item['description'] ?? '');
                        $productId = $productMapping[$desc] ?? '';

                        fputcsv($file, [
                            $date,
                            $customerId,
                            $customerName,
                            $orderId,
                            $productId, // ProductID 
                            $desc, // ProdDesc
                            $item['qty'] ?? ($item['quantity'] ?? '1'), // Qty
                            $item['price'] ?? '', // Price
                            '', // Class - Not in DB
                            $poNumber
                        ]);
                    }
                }
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
