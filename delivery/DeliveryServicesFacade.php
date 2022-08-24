<?php

namespace Delivery;

class DeliveryServicesFacade
{
    public function getDeliveryCosts(Parcel $parcel): array
    {
        $services = DeliveryServiceProvider::getDeliveryServices();
        $deliveryCosts = [];

        foreach ($services as $service) {
            /**
             * @var DeliveryInterface $deliveryService ;
             */
            $deliveryService = new $service($parcel);
            $deliveryTerms = $deliveryService->getDeliveryTerms();
            $deliveryCosts[] = [
                'company'       => $deliveryService::getCarrierName(),
                'carrierType'   => $deliveryService::getDeliveryTypeText(),
                'deliveryTerms' => $deliveryTerms,
            ];
        }

        return $deliveryCosts;
    }
}