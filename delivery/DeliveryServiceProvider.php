<?php

namespace Delivery;

class DeliveryServiceProvider
{
    public static function getDeliveryServices()
    {
        return [
            CompanyAppleDelivery::class,
            CompanyTurtleDelivery::class,
        ];
    }
}