<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->fullText();
            $table->decimal('price',10,2);
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->boolean('in_stock')->default(false);
            $table->float('rating',1);
            $table->timestamps();

            $table->index(['category_id', 'price']);
            $table->index(['category_id', 'created_at']);
            $table->index(['category_id', 'rating']);
        });
        DB::statement('ALTER TABLE products ADD CONSTRAINT check_rating_range CHECK (rating >= 1 AND rating <= 5)');
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
