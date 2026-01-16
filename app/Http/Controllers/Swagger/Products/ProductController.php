<?php

namespace App\Http\Controllers\Swagger\Products;
use OpenApi\Attributes as OA;

class ProductController
{
    #[OA\Get(
        path: "/api/products",
        summary: "Products list with filters and pagination",
        tags: ["Products"],
        parameters: [
            new OA\QueryParameter(
                name: "page",
                description: "Page number",
                required: false,
                schema: new OA\Schema(type: "integer", minimum: 1)
            ),
            new OA\QueryParameter(
                name: "per_page",
                description: "Items per page (1–100)",
                required: false,
                schema: new OA\Schema(type: "integer", minimum: 1, maximum: 100, default: 20)
            ),
            new OA\QueryParameter(
                name: "q",
                description: "Search query (max 255 chars)",
                required: false,
                schema: new OA\Schema(type: "string", maxLength: 255)
            ),
            new OA\QueryParameter(
                name: "price_from",
                description: "Minimal price (>= 0)",
                required: false,
                schema: new OA\Schema(type: "number", format: "float", minimum: 0)
            ),
            new OA\QueryParameter(
                name: "price_to",
                description: "Maximum price (>= 0, >= price_from)",
                required: false,
                schema: new OA\Schema(type: "number", format: "float", minimum: 0)
            ),
            new OA\QueryParameter(
                name: "category_id",
                description: "Category ID (existing category)",
                required: false,
                schema: new OA\Schema(type: "integer", minimum: 1)
            ),
            new OA\QueryParameter(
                name: "in_stock",
                description: "Only products in stock (true/false)",
                required: false,
                schema: new OA\Schema(type: "boolean")
            ),
            new OA\QueryParameter(
                name: "rating_from",
                description: "Minimal rating from 1 to 5",
                required: false,
                schema: new OA\Schema(type: "number", minimum: 1, maximum: 5)
            ),
            new OA\QueryParameter(
                name: "sort",
                description: "Sort option (one of enum ProductSort)",
                required: false,
                schema: new OA\Schema(
                    type: "string",
                enum: ["price_asc", "price_desc", "name_asc", "name_desc"]
                )
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Successful products list response"
            ),
            new OA\Response(
                response: 422,
                description: "Validation error"
            ),
        ]
    )]
    public function index()
    {

    }
}
