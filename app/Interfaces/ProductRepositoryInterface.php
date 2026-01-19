<?php

namespace App\Interfaces;

use App\DTOs\ProductFilterDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function filter(ProductFilterDTO $filters):LengthAwarePaginator;
}
