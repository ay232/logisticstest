<?php

namespace Delivery;

class CompanyAppleDelivery extends Delivery
{
    /**
     * Добавлено для имитации, что в классе указан адрес API для конкретной службы доставки
     */
    protected const API_BASE_URL = 'https://apple-delivery-fast.com/api/v1/';

    /**
     * @return string
     */
    public static function getCarrierName(): string
    {
        return 'Apple Delivery Company';
    }

    /**
     * @return string
     */
    public static function getDeliveryType(): string
    {
        return self::DELIVERY_TYPE_FAST;
    }

    /**
     * Этот метод имитирует обращение к поставщику услуги и возвращает расчётные параметры доставки.
     *
     * @param string $sourceKladr
     * @param string $targetKladr
     * @param float $weight
     * @return array
     */
    public function getDeliveryTerms(): array
    {
        $delivertyTerms = $this->getDeliveryTermsFromCarrier();

        return [
            'price'  => $this->getPriceFromCarrierResponse($delivertyTerms),
            'period' => $this->getDateFromCarrierResponse($delivertyTerms),
        ];
    }

    /**
     * @param array $response
     * @return string
     * @throws \Exception
     */
    protected function getDateFromCarrierResponse(array $response): string
    {
        $now = date_create();
        $days = $response['period'];
        $period = new \DateInterval(sprintf('P%sD', $days));
        $date = $now->add($period);

        return $date->format('Y-m-d');
    }

    /**
     * @param array $response
     * @return float
     */
    protected function getPriceFromCarrierResponse(array $response): float
    {
        return $response['price'];
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getDeliveryTermsFromCarrier(): array
    {
        //В рабочей реализации здесь будет код обращения к self::API_BASE_URL;
        //Данные для обращения к API будут браться из объекта $this->parcel
        //Так как это тестовое задание - то данные будут рандомизированы

        $response = [
            'price'  => mt_rand(300, 1000),
            'period' => mt_rand(1, 10),
            'error'  => null,
        ];

        return $this->validateCarrierResponse($response);
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function validateCarrierResponse(array $response): array
    {
        if (empty($response['price'])) {
            throw new \Exception('В ответе транспортной компании отсутствуют данные для оценки стоимости');
        }

        if (! empty($response['error'])) {
            throw new \Exception(sprintf('В ответе транспортной компании возвращена ошибка: %s', $response['error']));
        }

        if (empty($response['period'])) {
            throw new \Exception('В ответе транспортной компании отсутсвует срок доставки');
        }

        return $response;
    }
}