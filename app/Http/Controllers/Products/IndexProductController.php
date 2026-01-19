<?php

namespace App\Http\Controllers\Products;

use App\Actions\GetProductsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IndexProductController extends Controller
{
    public function __invoke(IndexProductRequest $request, GetProductsAction $action): AnonymousResourceCollection
    {
        $products = $action->execute($request->validated());

        return ProductResource::collection($products);
    }
}
