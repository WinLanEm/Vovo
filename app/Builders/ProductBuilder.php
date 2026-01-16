<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;
use App\Enums\ProductSort;

class ProductBuilder extends Builder
{
    public function filterByRequest(array $filters):self
    {
        return $this
            ->when($filters['q'] ?? null, fn($q, $search) => $q->search($search))
            ->when($filters['category_id'] ?? null, fn($q,$id) => $q->where('category_id',$id))
            ->when(isset($filters['in_stock']) ?? null, fn($q,$stockValue) => $q->where('in_stock',$filters['in_stock']))
            ->when($filters['price_from'] ?? null, fn($q,$priceFrom) => $q->where('price', '>=' ,$priceFrom))
            ->when($filters['price_to'] ?? null, fn($q,$priceTo) => $q->where('price', '<=' ,$priceTo));
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
