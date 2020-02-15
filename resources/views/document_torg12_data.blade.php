@php

    $document->load('supplies');
    $supply = $document->getSupply();

    $products = $supply->products;

    $plannedDate = new DateTime($supply->planned_date);

    $fullTotalPrice = \App\Services\SupplyService::bringTotalPrice($supply);

    $data = [
        'ГРУЗОПОЛУЧАТЕЛЬ' => \App\Services\Document\TemplateService::renderContragent($supply->customer),
        'ГРУЗООТПРАВИТЕЛЬ' => \App\Services\Document\TemplateService::renderContragent($supply->supplier),
        'ДЕНЬ' => $plannedDate->format('d'),
        'МЕСЯЦ_Р' => \App\Services\Service\OrfoService::getMonth($plannedDate, 'gen', true),
        'ГОД' => $plannedDate->format('Y'),
        'ДАТА' => $plannedDate->format('d.m.Y'),
        'ПОЛНАЯ_СУММА' => \App\Services\Document\TemplateService::sum2words($fullTotalPrice)
    ];

    $data['ПЛАТЕЛЬЩИК'] = $data['ГРУЗОПОЛУЧАТЕЛЬ'];
    $data['ПОСТАВЩИК'] = $data['ГРУЗООТПРАВИТЕЛЬ'];

    // МБОУ "КАНТЕМИРОВСКИЙ ЛИЦЕЙ", ИНН 3612005593, 396731, Воронежская обл, Кантемировский р-н, Кантемировка рп, Первомайская ул, дом No 35, тел.:
    // Грузополучатель 8(47367) 6-10-67, р/с 40204810600000000743, в банке ОТДЕЛЕНИЕ ВОРОНЕЖ, БИК 042007001

    foreach ($products as $key => $product) {
        $data['items'][] = [
            'loop' => $key + 1,
            'name' => $product->parent->name,
            'price' => $product->price,
            'mount' => $product->mount,
            'totalPrice' => round($product->price * $product->mount, 2),
            'sou' => $product->parent->sizeOfUnit->name
        ];
    }

@endphp

{!! json_encode($data) !!}
