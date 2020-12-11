<?php

/** @var \App\Models\Document\Document $document */

use ArtARTs36\RuSpelling\Month;

$document = $document->load('productTransportWaybills');

/** @var \App\Bundles\Supply\Models\ProductTransportWaybill $waybill */
$waybill = $document->getProductTransportWaybill();

$supply = $waybill->supply;

$products = $supply->products;

$plannedDate = new DateTime($supply->planned_date);

$fullTotalPrice = app(\App\Bundles\Supply\Services\SupplyService::class)->bringTotalPrice($supply);

$data = [
    'ГРУЗОПОЛУЧАТЕЛЬ' => \App\Services\Document\TemplateService::renderContragent($supply->customer),
    'ГРУЗООТПРАВИТЕЛЬ' => \App\Services\Document\TemplateService::renderContragent($supply->supplier),
    'ДЕНЬ' => $plannedDate->format('d'),
    'МЕСЯЦ_Р' => mb_strtolower(Month::getGenitiveName($plannedDate)),
    'ГОД' => $plannedDate->format('Y'),
    'ДАТА' => $plannedDate->format('d.m.Y'),
    'ПОЛНАЯ_СУММА' => \App\Services\Document\TemplateService::sum2words($fullTotalPrice)
];

$data['ПЛАТЕЛЬЩИК'] = $data['ГРУЗОПОЛУЧАТЕЛЬ'];
$data['ПОСТАВЩИК'] = $data['ГРУЗООТПРАВИТЕЛЬ'];

// МБОУ "КАНТЕМИРОВСКИЙ ЛИЦЕЙ", ИНН 3612005593, 396731, Воронежская обл, Кантемировский р-н, Кантемировка рп, Первомайская ул, дом No 35, тел.:
// Грузополучатель 8(47367) 6-10-67, р/с 40204810600000000743, в банке ОТДЕЛЕНИЕ ВОРОНЕЖ, БИК 042007001

foreach ($products as $key => $product) {
    $data['[ТОВАР_I]'][] = $key + 1;
    $data['[ТОВАР]'][] = $product->parent->name;
    $data['[ТОВАР_ЦЕНА]'][] = $product->price;
    $data['[ТОВАР_КОЛВО]'][] = $product->quantity;
    $data['[ТОВАР_СУММ]'][] = $product->getTotalPrice();
    $data['[ТОВАР_ЕД_ИЗМ]'][] = $product->parent->sizeOfUnit->name;
}

return $data;
