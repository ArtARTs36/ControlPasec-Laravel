<?php

namespace App\Bundles\Supply\Services;

use App\Bundles\Supply\Contracts\Creator;
use App\Bundles\Supply\Contracts\SupplyCreateOption;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\Supply\Models\Supply;
use App\Bundles\Supply\Models\SupplyProduct;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SupplyCreator implements Creator
{
    protected $options;

    protected $fillable;

    protected $productFillable;

    /**
     * @param array<SupplyCreateOption> $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
        $this->fillable = (new Supply())->getFillable();
        $this->productFillable = (new SupplyProduct())->getFillable();
    }

    /**
     * @param array $supplies
     * @param array|null $options
     * @return ActionResponse
     */
    public function many(array $supplies, array $options = []): ActionResponse
    {
        $options = array_intersect($options, array_keys($this->options));

        try {
            DB::beginTransaction();

            $products = [];

            /** @var array $supplyData */
            foreach ($supplies as $supplyData) {
                $supply = $this->createSupply($supplyData);

                foreach ($supplyData['products'] as $product) {
                    $products[] = $this->makeProductData($product, $supply);
                }

                if (! empty($options)) {
                    $this->performOptions($supply, $options);
                }
            }

            SupplyProduct::query()->insert($products);

            DB::commit();

            $response = new ActionResponse(true);
        } catch (\Exception $e) {
            DB::rollBack();

            $response = new ActionResponse(false, __('supply.create-many-error', [
                'msg' => $e->getMessage(),
            ]), Response::HTTP_CONFLICT);
        } finally {
            return $response;
        }
    }

    public function hasOption(string $name): bool
    {
        return isset($this->options[$name]);
    }

    protected function makeProductData(array $data, Supply $supply): array
    {
        return array_merge(
            Arr::only($data, $this->productFillable),
            [
                SupplyProduct::FIELD_SUPPLY_ID => $supply->id,
            ]
        );
    }

    protected function createSupply(array $data): Supply
    {
        return Supply::query()->create(Arr::only($data, $this->fillable));
    }

    protected function performOptions(Supply $supply, array $options): void
    {
        foreach ($options as $name) {
            $this->options[$name]->handle($supply);
        }
    }
}
