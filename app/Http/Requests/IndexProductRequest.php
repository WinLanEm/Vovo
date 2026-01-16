<?php

namespace App\Http\Requests;

use App\Enums\ProductSort;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page' => 'nullable|int',
            'per_page' => 'nullable|int|min:1|max:100',
            'q' => 'string|nullable|max:255',
            'price_from' => 'numeric|nullable|min:0',
            'price_to' => 'numeric|nullable|min:0|gte:price_from',
            'category_id' => 'integer|nullable|exists:categories,id',
            'in_stock' => 'boolean|nullable',
            'rating_from' => 'numeric|nullable|min:1|max:5',
            'sort' => ['nullable','string', Rule::enum(ProductSort::class)]
        ];
    }

    public function messages(): array
    {
        return [
            'page.int' => 'The page must be an integer.',

            'per_page.int' => 'The page must be an integer.',
            'per_page.min' => 'The minimum per page must be at least 1.',
            'per_page.max' => 'The page must not be greater than 100.',

            'q.string' => 'The search query must be a string.',
            'q.max' => 'The search query must not be greater than 255 characters.',

            'price_from.numeric' => 'The minimum price must be a number.',
            'price_from.min' => 'The minimum price must be at least 0.',

            'price_to.numeric' => 'The maximum price must be a number.',
            'price_to.min' => 'The maximum price must be at least 0.',
            'price_to.gte' => 'The maximum price must be greater than or equal to the minimum price.',

            'category_id.integer' => 'The category ID must be an integer.',
            'category_id.exists' => 'The selected category is invalid.',

            'in_stock.boolean' => 'The in stock field must be true or false.',

            'rating_from.numeric' => 'The rating must be a number.',
            'rating_from.min' => 'The rating must be at least 1.',
            'rating_from.max' => 'The rating must not be greater than 5.',

            'sort.string' => 'The sort parameter must be a string.',
            'sort.enum' => 'The selected sort option is invalid.',
        ];
    }

    protected function prepareForValidation():void
    {
        if ($this->has('in_stock')) {
            $this->merge([
                'in_stock' => $this->boolean('in_stock'),
            ]);
        }
    }
}
