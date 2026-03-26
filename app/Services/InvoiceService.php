<?php

namespace App\Services;

class InvoiceService
{
    public function generateInvoiceNo($orderId)
    {
        return 'I000'.$orderId;
    }

}
