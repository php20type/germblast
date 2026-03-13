<?php

namespace App\Services;

class OrderService
{
    public function generateOrderNo($serviceId)
    {
        return 'ORD00'.$serviceId;
    }
}
