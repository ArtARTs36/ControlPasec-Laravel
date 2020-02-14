@php
    $document->load([
        'scoreForPayments'
    ]);

    $scores = $document->scoreForPayments;
@endphp

    <!doctype html>
<html>
<head><title>Счета на оплату</title>
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
            border: 1px #efefef solid;
            font-size: 14pt;
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

        div.page_break {
            page-break-before: always;
        }
    </style>
</head>
<body>

<br/>
<br/>
<br/>

@foreach($scores as $scoreIndex => $score)
    @php
        $supply = $score->supply;
        $supplier = $supply->supplier->load(['requisites' => function($requisite) {
            return $requisite->with('bank');
        }]);
        $customer = $supply->customer;
        $products = $supply->products()->with(['parent' => function($parent) {
            return $parent->with('sizeOfUnit');
        }])->get();

        $totalPrice = \App\Services\SupplyService::bringTotalPrice($supply);
    @endphp

    <table width="100%" cellpadding="2" cellspacing="2" class="invoice_bank_rekv">
        <tr>
            <td colspan="2" rowspan="2" style="min-height:13mm; width: 105mm;">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="height: 13mm;">
                    <tr>
                        <td valign="top">
                            <div></div>
                        </td>
                    </tr>
                    <tr>
                        <td valign="bottom" style="height: 3mm;">
                            <div style="font-size:10pt;">Банк получателя</div>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="min-height:7mm;height:auto; width: 25mm;">
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
                            <div>{{ $supplier->title }}</div>
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
    <div style="font-weight: bold; font-size: 16pt; padding-left:5px;">Счет № 1 от 13.02.2020</div>
    <br/>
    <div style="background-color:#000000; width:100%; font-size:1px; height:2px;">&nbsp;</div>
    <table width="100%">
        <tr>
            <td style="width: 30mm;">
                <div style=" padding-left:2px;">Поставщик:</div>
            </td>
            <td>
                <div style="font-weight:bold;  padding-left:2px;">{{ $supplier->full_title_with_opf }}</div>
            </td>
        </tr>
        <tr>
            <td style="width: 30mm;">
                <div style=" padding-left:2px;">Покупатель:</div>
            </td>
            <td>
                <div style="font-weight:bold;  padding-left:2px;">
                    {{ $customer->title }}, ИНН {{ $customer->inn }}, КПП {{ $customer->kpp }},
                    {{ $customer->address_postal }}, {{ $customer->address }}
                </div>
            </td>
        </tr>
    </table>
    <table class="invoice_items" width="100%" cellpadding="2" cellspacing="2">
        <thead>
        <tr>
            <th style="width:13mm;">№</th>
            <th>Товар</th>
            <th style="width:20mm;">Кол-во</th>
            <th style="width:17mm;">Ед.</th>
            <th style="width:27mm;">Цена</th>
            <th style="width:27mm;">Сумма</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($products as $key => $product)
            <tr>
                <td>
                    {{ $key }}
                </td>
                <td>
                    {{ $product->parent->name_for_document }}
                </td>
                <td>
                    {{ $product->mount }}
                </td>
                <td>
                    {{ $product->parent->sizeOfUnit->short_name }}
                </td>
                <td>
                    {{ $product->price }}
                </td>
                <td>
                    {{ $product->mount * $product->price }}
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
            <td style="width:27mm; font-weight:bold;  text-align:right;">{{ $totalPrice }}</td>
        </tr>
        </tbody>
    </table>
    <br/>
    <div>Всего наименований 0 на сумму 0.00 рублей.<br/>ноль рублей 00 копеек</div>
    <br/><br/>
    <div style="background-color:#000000; width:100%; font-size:1px; height:2px;">&nbsp;</div>
    <br/>
    <div>Подпись ______________________ ({{ $supplier->title }})</div>

    @if($scoreIndex < count($scores) - 1)
    <div class="page_break"></div>
    @endif

@endforeach

</body>
</html>
