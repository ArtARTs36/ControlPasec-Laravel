<?php

    /** @var Document $document */
    use App\Models\Document\Document;
    use App\Models\Supply\ProductTransportWaybill;
    use App\Models\Supply\SupplyProduct;
    use App\Services\Document\TemplateService;
    use App\Services\SupplyService;

    $document = $document->load('productTransportWaybills');

    /** @var ProductTransportWaybill $waybill */
    $waybill = $document->getProductTransportWaybill();

    $supply = $waybill->supply;

    /** @var SupplyProduct[] $products */
    $products = $supply->products;

    $plannedDate = new \DateTime($supply->planned_date);

    $fullTotalPrice = SupplyService::bringTotalPrice($supply);

    $data = [
        'ГРУЗОПОЛУЧАТЕЛЬ' => TemplateService::renderContragent($supply->customer),
        'ГРУЗООТПРАВИТЕЛЬ' => TemplateService::renderContragent($supply->supplier),
        'ДЕНЬ' => $plannedDate->format('d'),
        'МЕСЯЦ_Р' => \ArtARTs36\RuSpelling\Month::getGenitiveName($plannedDate),
        'ГОД' => $plannedDate->format('Y'),
        'ДАТА' => $plannedDate->format('d.m.Y'),
        'ПОЛНАЯ_СУММА' => TemplateService::sum2words($fullTotalPrice),
        'КОЛВО_ПРОД' => count($products),
        'КОЛВО_ПРОДУКТОВ_ПРОПИСЬЮ' => TemplateService::numberToWord(count($products)),
    ];

    $data['ПЛАТЕЛЬЩИК'] = $data['ГРУЗОПОЛУЧАТЕЛЬ'];
    $data['ПОСТАВЩИК'] = $data['ГРУЗООТПРАВИТЕЛЬ'];

    $totalQuantity = 0;

    $netto = new \ArtARTs36\RuSpelling\Formatter\NumbersFormats\Netto();

    foreach ($products as $key => $product) {
        $data['items'][] = [
            'loop' => $key + 1,
            'name' => $product->parent->name,
            'price' => $netto->to($product->price),
            'quantity' => $netto->to($product->quantity),
            'totalPrice' => $netto->to($product->getTotalPrice()),
            'sou' => $product->quantityUnit->short_name,
            'okei' => $product->quantityUnit->okei,
        ];

        $totalQuantity += $product->quantity;
    }

    $data['ИТОГО_НЕТТО'] = $netto->to($totalQuantity);
    $data['СУММА_БЕЗ_НДС'] = $netto->to($fullTotalPrice);
    $data['СУММА_С_НДС'] = $netto->to($fullTotalPrice);

return $data;
