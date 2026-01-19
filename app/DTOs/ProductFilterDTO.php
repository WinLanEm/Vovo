<?php

namespace App\DTOs;


readonly class ProductFilterDTO
{
    public function __construct(
        public ?string $q = null,
        public ?int $categoryId = null,
        public ?bool $inStock = null,
        public ?float $priceFrom = null,
        public ?float $priceTo = null,
        public ?float $ratingFrom = null,
        public ?string $sort = null,
        public ?int $perPage = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            q: $data['q'] ?? null,
            categoryId: $data['category_id'] ?? null,
            inStock: $data['in_stock'] ?? null,
            priceFrom: $data['price_from'] ?? null,
            priceTo: $data['price_to'] ?? null,
            ratingFrom: $data['rating_from'] ?? null,
            sort: $data['sort'] ?? null,
            perPage: $data['per_page'] ?? null,
        );
    }
}
