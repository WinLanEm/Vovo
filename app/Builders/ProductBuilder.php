<?php

namespace App\Builders;

use App\DTOs\ProductFilterDTO;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\ProductSort;

class ProductBuilder extends Builder
{
    public function filterByRequest(ProductFilterDTO $filters):self
    {
        return $this
            ->when($filters->q ?? null, fn($q, $search) => $q->search($search))
            ->when($filters->categoryId ?? null, fn($q,$id) => $q->where('category_id',$id))
            ->when($filters->inStock !== null, fn($q, $val) => $q->where('in_stock', $filters->inStock))
            ->when($filters->priceFrom ?? null, fn($q,$priceFrom) => $q->where('price', '>=' ,$priceFrom))
            ->when($filters->priceTo ?? null, fn($q,$priceTo) => $q->where('price', '<=' ,$priceTo));
    }

    public function search(string $word): self
    {
        return $this->whereFullText('name', $word);
    }

    public function sortByRequest(?string $sort): self
    {
        $sortParam = ProductSort::tryFrom($sort);
        return match ($sortParam) {
            ProductSort::PRICE_DESC => $this->orderBy('price', 'desc'),
            ProductSort::PRICE_ASC => $this->orderBy('price'),
            ProductSort::RATING_DESC => $this->orderBy('rating', 'desc'),
            ProductSort::NEWEST => $this->orderBy('created_at', 'desc'),
            default => $this,
        };
    }
}
