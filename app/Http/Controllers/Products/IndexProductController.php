<?php

namespace App\Http\Controllers\Products;

use App\DTOs\ProductFilterDTO;
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
        $data = ProductFilterDTO::fromRequest($request);

        $products = Product::query()
            ->filterByRequest($data)
            ->sortByRequest($data->sort ?? null)
            ->paginate($data->perPage ?? self::PER_PAGE);

        return ProductResource::collection($products);
    }
}
