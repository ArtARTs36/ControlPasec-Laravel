@php
    $document->load([
        'scoreForPayments',
        'scoreForPayments.supply.supplier.requisites.bank',
        'scoreForPayments.supply.products.parent.sizeOfUnit',
        'scoreForPayments.supply.customer',
    ]);

    $score = $document->getScoreForPayment();

    $supply = $score->supply;
    $supplier = $supply->supplier;

    $supplierHelper = \App\Helper\SupplierHelper::getInstance($supplier);

    $customer = $supply->customer;

    /** @var \App\Models\Supply\SupplyProduct[] $products */
    $products = $supply->products;

    $totalPrice = \App\Services\SupplyService::bringTotalPrice($supply);
@endphp

<!doctype html>
<html>
<head><title>Счет на оплату - {{ $customer->title }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        *, body, html {
            margin: 0;
            padding: 0;
        }
        body {
            width: 90%;
            margin-left: auto;
            margin-right: auto;
            font-size: 12pt;
        }

        table td, table th {
            padding: 3px;
        }

        table.invoice_bank_rekv {
            border-collapse: collapse;
            border: 1px solid;
        }

        table.invoice_bank_rekv > tbody > tr > td, table.invoice_bank_rekv > tr > td {
            border: 1px solid;
        }

        table.invoice_items {
            border: 1px solid;
            border-collapse: collapse;
        }

        table.invoice_items td, table.invoice_items th {
            border: 1px solid;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        div.page_break {
            page-break-before: always;
        }
    </style>
</head>
<body>
<br/>
<br/>

<table width="100%" cellpadding="2" cellspacing="2" class="invoice_bank_rekv">
    <tr>
        <td colspan="2" rowspan="2" style="min-height:13mm; width: 105mm;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="height: 13mm;">
                <tr>
                    <td valign="top">
                        <div>{{ $supplier->getDefaultRequisite()->bank->full_name }}</div>
                    </td>
                </tr>
                <tr>
                    <td valign="bottom" style="height: 3mm; margin-top: 5px;">
                        <div style="font-size:10pt;">Банк получателя</div>
                    </td>
                </tr>
            </table>
        </td>
        <td style="min-height:5mm;height:auto; width: 25mm;">
            <div>БИK</div>
        </td>
        <td rowspan="2" style="vertical-align: top; width: 60mm;">
            <div style=" height: 7mm; line-height: 7mm; vertical-align: middle;">{{ $supplier->getDefaultRequisite()->bank->bik }}</div>
            <div>{{ $supplier->getDefaultRequisite()->bank->score }}</div>
        </td>
    </tr>
    <tr>
        <td style="width: 25mm;">
            <div>Сч. №</div>
        </td>
    </tr>
    <tr>
        <td style="min-height:6mm; height:auto; width: 50mm;">
            <div>ИНН {{ $supplier->inn }}</div>
        </td>
        <td style="min-height:6mm; height:auto; width: 55mm;">
            <div>КПП {{ $supplier->kpp }}</div>
        </td>
        <td rowspan="2" style="min-height:19mm; height:auto; vertical-align: top; width: 25mm;">
            <div>Сч. №</div>
        </td>
        <td rowspan="2" style="min-height:19mm; height:auto; vertical-align: top; width: 60mm;">
            <div>{{ $supplier->getDefaultRequisite()->score }}</div>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="min-height:13mm; height:auto;">
            <table border="0" cellpadding="0" cellspacing="0" style="height: 13mm; width: 105mm;">
                <tr>
                    <td valign="top">
                        <div>{{ $supplier->getTitleForDocument() }}</div>
                    </td>
                </tr>
                <tr>
                    <td valign="bottom" style="height: 3mm;">
                        <div style="font-size: 10pt;">Получатель</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br/>
<div style="font-weight: bold; font-size: 16pt; padding-left:5px;">
    Счет на оплату № {{$score->order_number}} от
    {{(new DateTime($score->date))->format('d.m.Y')}}
</div>
<br/>
<div style="background-color:#000000; width:100%; font-size:1px; height:2px;">&nbsp;</div>
<table width="100%">
    <tr>
        <td style="width: 30mm;">
            <div style="padding-left:2px;">Поставщик</div>
            <div style="padding-left:2px;">(Исполнитель):</div>
        </td>
        <td>
            <div style="font-weight:bold;  padding-left:2px;">
                {{ \App\Services\Document\TemplateService::renderContragent($supplier, true) }}
            </div>
        </td>
    </tr>
    <tr>
        <td style="width: 30mm;">
            <div style="padding-left:2px;">Покупатель:</div>
            <div style="padding-left:2px;">(Заказчик):</div>
        </td>
        <td>
            <div style="font-weight:bold;  padding-left:2px;">
                {{ \App\Services\Document\TemplateService::renderContragent($customer, true) }}
            </div>
        </td>
    </tr>
</table>
<table class="invoice_items" width="100%" cellpadding="2" cellspacing="2">
    <thead>
    <tr>
        <th class="text-center" width="5%">№</th>
        <th class="text-center" width="50%">Товары (работы, услуги)</th>
        <th style="" class="text-center" width="10%">Кол-во</th>
        <th style="" class="text-center" width="10%">Ед.</th>
        <th style="" class="text-center" width="10%">Цена</th>
        <th style="" class="text-center" width="15%">Сумма</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($products as $key => $product)
        <tr>
            <td>
                {{ $key + 1 }}
            </td>
            <td>
                {{ $product->parent->name_for_document }}
            </td>
            <td class="text-right">
                {{ $product->quantity }}
            </td>
            <td>
                {{ $product->parent->sizeOfUnit->short_name }}
            </td>
            <td class="text-right">
                {{ \App\Services\Document\TemplateService::formatPriceOne($product->price) }}
            </td>
            <td class="text-right">
                {{ \App\Services\Document\TemplateService::formatPriceOne($product->getTotalPrice()) }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<table border="0" width="100%" cellpadding="1" cellspacing="1">
    <tbody>
    <tr>
        <td></td>
        <td style="width:27mm; font-weight:bold;  text-align:right;">Итого:</td>
        <td style="width:27mm; font-weight:bold;  text-align:right;">
            {{ \App\Services\Document\TemplateService::formatPriceOne($totalPrice) }}
        </td>
    </tr>
    <tr>
        <td></td>
        <td style="width:50mm; font-weight:bold;  text-align:right;">Без налога (НДС)</td>
        <td style="width:27mm; font-weight:bold;  text-align:right;">
            -
        </td>
    </tr>
    <tr>
        <td></td>
        <td style="width:50mm; font-weight:bold;  text-align:right;">Всего к оплате</td>
        <td style="width:27mm; font-weight:bold;  text-align:right;">
            {{ \App\Services\Document\TemplateService::formatPriceOne($totalPrice) }}
        </td>
    </tr>
    </tbody>
</table>

<div>
    Всего наименований {{ count($supply->products) }},
    на сумму {{ \App\Services\Document\TemplateService::formatPriceOne($totalPrice) }}
    {{ $products[0]->parent->currency->short_name}}.
    <br/>
    <strong>
    {{ \App\Services\Document\TemplateService::sum2words($totalPrice) }}
    </strong>
</div>

<br/>
<br/>

<div>
    Оплата данного счета означает согласие с условиями поставки товара. <br>
    Уведомление об оплате обязательно, в противном случае не гарантируется наличие товара на складе. <br>
    Товар отпускается по факту прихода денег на р/с Поставщика, самовывозом, при наличии доверенности и
    паспорта.
</div>

<br/><br/>
<div style="background-color:#000000; width:100%; font-size:1px; height:2px;">&nbsp;</div>
<br/>
<div style="width:100%">
    Подпись
    <span style="float:right; text-align: right;">
        <i>
            {{ $supplierHelper->getSignature() }}
        </i>
    </span>
    <div style="position:relative; margin-left: 65px; background-color:#000000; width:100%; font-size:1px; height:2px;">&nbsp;</div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</body>
</html>
