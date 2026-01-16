<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class IndexProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_fulltext_search(): void
    {
        $category = Category::factory()->create();

        Product::factory()->count(5)->create([
            'category_id' => $category->id,
            'name' => 'Super Good Product iPhone Pro'
        ]);
        Product::factory()->count(5)->create([
            'category_id' => $category->id,
            'name' => 'Bad Widget Samsung TV'
        ]);

        //to create a full-text index
        DB::connection()->getPdo()->commit();

        $response = $this->get(route('products.index', ['q' => 'good']));
        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
    }


    public function test_filters_price_range(): void
    {
        $category = Category::factory()->create();
        Product::factory()->count(5)->create(['category_id' => $category->id, 'price' => 100]);
        Product::factory()->count(5)->create(['category_id' => $category->id, 'price' => 200]);

        $response = $this->get(route('products.index', [
            'price_from' => 150,
            'price_to' => 250
        ]));
        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
    }

    public function test_filter_category(): void
    {
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();
        Product::factory(3)->create(['category_id' => $category1->id]);
        Product::factory(3)->create(['category_id' => $category2->id]);

        $response = $this->get(route('products.index', ['category_id' => $category1->id]));
        $response->assertJsonCount(3, 'data');
    }

    public function test_filter_in_stock(): void
    {
        $category = Category::factory()->create();
        Product::factory(3)->create(['category_id' => $category->id, 'in_stock' => true]);
        Product::factory(3)->create(['category_id' => $category->id, 'in_stock' => false]);

        $response = $this->get(route('products.index', ['in_stock' => true]));
        $response->assertJsonCount(3, 'data');
    }

    public function test_combined_filters(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'name' => 'Good Product',
            'price' => 150,
            'in_stock' => true
        ]);
        Product::factory()->create(['category_id' => $category->id, 'price' => 100]);

        DB::connection()->getPdo()->commit();

        $response = $this->get(route('products.index', [
            'q' => 'good',
            'price_from' => 120,
            'in_stock' => true,
            'category_id' => $category->id
        ]));

        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['id' => $product->id]);
    }

    public function test_pagination(): void
    {
        $category = Category::factory()->create();
        Product::factory(25)->create(['category_id' => $category->id]);

        $response = $this->get(route('products.index', ['per_page' => 10, 'page' => 2]));
        $response->assertJsonCount(10, 'data');
        $response->assertJsonPath('meta.current_page', 2);
        $response->assertJsonPath('meta.last_page', 3);
    }

    public function test_validation_error(): void
    {
        $response = $this->getJson(route('products.index', ['price_from' => -1]));
        $response->assertStatus(422);
        $response->assertInvalid(['price_from']);
    }

    public function test_sorting(): void
    {
        $category = Category::factory()->create();
        Product::factory()->create(['category_id' => $category->id, 'price' => 100]);
        Product::factory()->create(['category_id' => $category->id, 'price' => 200]);

        $response = $this->get(route('products.index', ['sort' => 'price_desc']));
        $response->assertStatus(200);

        $response->assertJsonPath('data.0.price', 200);
    }

    public function test_invalid_sort_validation(): void
    {
        $response = $this->getJson(route('products.index', ['sort' => 'invalid']));
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['sort']);
    }
}
