<?php

namespace App\Services\Supply;

use App\Http\Responses\ActionResponse;
use App\Models\Supply\ScoreForPayment;
use App\Models\Supply\Supply;
use App\Models\Supply\SupplyProduct;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * Class SupplyCreator
 * @package App\Services\Supply
 */
class SupplyCreator
{
    public const OPTION_SCORE_FOR_PAYMENT = 'score';

    public const OPTIONS = [
        self::OPTION_SCORE_FOR_PAYMENT,
    ];

    /**
     * @param array $supplies
     * @param array|null $options
     * @return ActionResponse
     */
    public static function many(array $supplies, array $options = [])
    {
        $fillable = (new Supply())->getFillable();
        $productFillable = (new SupplyProduct())->getFillable();

        $options = array_intersect($options, static::OPTIONS);

        try {
            DB::beginTransaction();

            $products = [];

            /** @var array $supplyData */
            foreach ($supplies as $supplyData) {
                /** @var Supply $supply */
                $supply = Supply::query()->create(Arr::only($supplyData, $fillable));

                foreach ($supplyData['products'] as $product) {
                    $products[] = array_merge(
                        Arr::only($product, $productFillable),
                        [
                            SupplyProduct::FIELD_SUPPLY_ID => $supply->id,
                        ]
                    );
                }

                if (!empty($options)) {
                    static::performSupplyOptions($supply, $options);
                }
            }

            SupplyProduct::query()->insert($products);

            $response = new ActionResponse(true);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $response = new ActionResponse(false, __('supply.create-many-error', [
                'msg' => $e->getMessage(),
            ]), Response::HTTP_CONFLICT);
        } finally {
            return $response;
        }
    }

    /**
     * @param Supply $supply
     * @param array $options
     */
    protected static function performSupplyOptions(Supply $supply, array $options): void
    {
        foreach ($options as $option) {
            if ($option === static::OPTION_SCORE_FOR_PAYMENT) {
                ScoreForPayment::createBySupply($supply);
            }
        }
    }
}
