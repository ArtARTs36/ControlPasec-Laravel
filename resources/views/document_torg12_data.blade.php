@php
    $data = [];

    $supply = \App\Services\SupplyService::fullLoadSupply(4);
    $products = $supply->products;

    foreach ($products as $key => $product) {
        $data['items'][] = [
            'loop' => $key + 1,
            'name' => $product->parent->name,
            'price' => $product->price,
            'mount' => $product->mount,
            'totalPrice' => $product->price * $product->mount
        ];
    }

@endphp

{!! json_encode($data) !!}
