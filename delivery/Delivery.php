<?php

namespace Delivery;

abstract class Delivery implements DeliveryInterface
{
    public const DELIVERY_TYPE_FAST = 'fast';

    public const DELIVERY_TYPE_SLOW = 'slow';

    public const DELIVERY_TYPES_MAP = [
        self::DELIVERY_TYPE_SLOW => 'Медленная доставка',
        self::DELIVERY_TYPE_FAST => 'Быстрая доставка',
    ];

    protected Parcel $parcel;

    /**
     * @param Parcel $parcel
     */
    public function __construct(Parcel $parcel)
    {
        $this->parcel = $parcel;
    }

    /**
     * @param Parcel $parcel
     * @return void
     */
    public function setParcel(Parcel $parcel)
    {
        $this->parcel = $parcel;
    }

    /**
     * @return string
     */
    abstract public static function getCarrierName(): string;

    /**
     * @return array
     */
    abstract public function getDeliveryTerms(): array;

    /**
     * @return string
     */
    abstract public static function getDeliveryType(): string;

    /**
     * @return string
     */
    public static function getDeliveryTypeText(): string
    {
        return static::DELIVERY_TYPES_MAP[static::getDeliveryType()] ?? static::getDeliveryType();
    }

    /**
     * @return array
     */
    abstract public function getDeliveryTermsFromCarrier(): array;

    abstract protected function getDateFromCarrierResponse(array $response): string;
}
