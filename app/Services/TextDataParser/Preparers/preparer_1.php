<?php

use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\Supply\Repositories\ScoreForPaymentRepository;
use App\Models\VariableDefinition;
use App\Services\Supply\SupplyProductService;
use App\Bundles\Supply\Services\SupplyService;
use App\Services\VariableDefinitionService;

/** @var array $items */

$result = [];
$supplier = Contragent::find(env('ONE_SUPPLIER_ID'));

$repository = app(ScoreForPaymentRepository::class);

/** @var array $item */
foreach ($items as $item) {
    $customer = Contragent::where('title', $item[1])->first();
    $supply = app(SupplyService::class)->create($customer, $supplier);

    /** @var \App\Bundles\Product\Models\Product $product */
    $product = VariableDefinitionService::getModel(VariableDefinition::PRODUCT_ID);
    $supplyProduct = SupplyProductService::makeSupplyProductOfParent($product);
    $supplyProduct->supply_id = $supply->id;
    $supplyProduct->quantity = $item[5];
    $supplyProduct->save();

    $score = $repository->createBySupply($supply);

    $result[] = [
        'customer' => $customer,
        'supply' => $supply,
        'supplier' => $supplier,
        'supplyProduct' => $supplyProduct,
        'score' => $score,
    ];
}

return $result;
