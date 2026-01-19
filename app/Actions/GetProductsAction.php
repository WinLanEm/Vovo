<?php

namespace App\Actions;

use App\DTOs\ProductFilterDTO;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class GetProductsAction
{
    CONST PER_PAGE = 20;
    public function execute(array $data): LengthAwarePaginator
    {
        $filters = ProductFilterDTO::fromArray($data);
        return Product::query()
            ->filterByRequest($filters)
            ->sortByRequest($filters->sort)
            ->paginate($filters->perPage ?? self::PER_PAGE);
    }
}
