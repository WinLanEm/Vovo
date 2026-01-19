<?php

namespace App\Repositories;

use App\DTOs\ProductFilterDTO;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    CONST PER_PAGE = 20;
    public function filter(ProductFilterDTO $filters): LengthAwarePaginator
    {
        return Product::query()
            ->filterByRequest($filters)
            ->sortByRequest($filters->sort)
            ->paginate($filters->perPage ?? self::PER_PAGE);
    }

}
