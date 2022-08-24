<?php

namespace Delivery;

interface DeliveryInterface
{
    /**
     * @return string
     */
    public static function getCarrierName(): string;

    /**
     * @param string $sourceKladr
     * @param string $targetKladr
     * @param float $weight
     * @return array
     */
    public function getDeliveryTerms(): array;

    /**
     * @return string
     */
    public static function getDeliveryType(): string;

    public static function getDeliveryTypeText(): string;
}
