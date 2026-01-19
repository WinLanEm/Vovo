<?php

namespace App\Actions;

use App\DTOs\ProductFilterDTO;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class GetProductsAction
{
    public function __construct(private ProductRepositoryInterface $productRepository){}

    public function execute(array $data): LengthAwarePaginator
    {
        $filters = ProductFilterDTO::fromArray($data);
        return $this->productRepository->filter($filters);
    }
}
