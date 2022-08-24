<?php
require_once('autoload.php');
use Delivery\Parcel;

echo '<h1 style="color: brown; border-bottom: brown 1px solid">Тестирование сервиса расчёта доставок</h1>';
$parcels = [
    new Parcel('Санкт-Петербург', 'Москва', 890),
    new Parcel('Рязань', 'Ростов', 164),
    new Parcel('Колыма', 'Вятка', 449),
    new Parcel('Владивосток', 'Саратов', 354)
        ];

foreach ($parcels as $parcel){
    echo sprintf('<h3 style="color: cornflowerblue">Расчёт посылки из %s в %s весом %s гр.</h3>', $parcel->getSourceKladr(), $parcel->getTargetKladr(), $parcel->getWeight());
    $service = new \Delivery\DeliveryServicesFacade();
    $deliveries = $service->getDeliveryCosts($parcel);
    echo '<table style="margin-left: 20px;"><thead><tr style="height: 40px; color: #009a25;"><td style="width: 200px;border-bottom: 1px solid black">Транспортная компания</td><td  style="width: 150px; border-bottom: 1px solid black">Тип доставки</td>';
    echo '<td style="width: 120px; border-bottom: 1px solid black">Цена доставки</td><td style="width: 120px; border-bottom: 1px solid black">Срок доставки</td></tr></thead>';
    foreach ($deliveries as $delivery){
        $price = number_format($delivery['deliveryTerms']['price'],2, ',', ' ');
        echo '<tr style="height: 40px;">';
        echo sprintf('<td>%s</td>', $delivery['company']);
        echo sprintf('<td>%s</td>', $delivery['carrierType']);
        echo sprintf('<td style="text-align: right">%s Р</td>', $price);
        echo sprintf('<td style="text-align: right">%s</td>', $delivery['deliveryTerms']['period']);
        echo '</tr>';
    }
    echo '</table>';
}


