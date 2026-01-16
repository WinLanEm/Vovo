<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IndexProductController extends Controller
{
    CONST PER_PAGE = 20;

    public function __invoke(IndexProductRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();
        $products = Product::query()
            ->filterByRequest($data)
            ->sortByRequest($data['sort'] ?? null)
            ->paginate($data['per_page'] ?? self::PER_PAGE);

        return ProductResource::collection($products);
    }
}
