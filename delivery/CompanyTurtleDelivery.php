<?php

namespace Delivery;

class CompanyTurtleDelivery extends Delivery
{
    /**
     * Добавлено для имитации, что в классе указан адрес API для конкретной службы доставки
     */
    protected const API_BASE_URL = 'https://turtle-delivery-fast.com/api/v1/';

    protected const DELIVERY_BASE_COST = 150;

    /**
     * @return string
     */
    public static function getCarrierName(): string
    {
        return 'Turtle Delivery Company';
    }

    /**
     * @return string
     */
    public static function getDeliveryType(): string
    {
        return self::DELIVERY_TYPE_SLOW;
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
        return $response['date'];
    }

    /**
     * @param array $response
     * @return float
     */
    protected function getPriceFromCarrierResponse(array $response): float
    {
        return self::DELIVERY_BASE_COST * $response['coefficient'];
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
        $days = mt_rand(5, 10);
        $period = new \DateInterval(sprintf('P%sD', $days));

        $response = [
            'coefficient' => mt_rand(120, 200) / 100,
            'date'        => date_create()->add($period)->format('Y-m-d'),
            'error'       => null,
        ];

        return $this->validateCarrierResponse($response);
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function validateCarrierResponse(array $response): array
    {
        if (empty($response['coefficient'])) {
            throw new \Exception('В ответе транспортной компании отсутствуют данные для оценки стоимости');
        }

        if (! empty($response['error'])) {
            throw new \Exception(sprintf('В ответе транспортной компании возвращена ошибка: %s', $response['error']));
        }

        if (empty($response['date'])) {
            throw new \Exception('В ответе транспортной компании отсутсвует срок доставки');
        }

        return $response;
    }
}