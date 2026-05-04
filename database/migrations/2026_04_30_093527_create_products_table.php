<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->string('name');        
            $table->text('description')->nullable();
            $table->decimal('price_sell', 10, 2);
            $table->decimal('price_buy', 10, 2)->nullable();
            $table->date('expiration_date')->nullable();
            $table->integer('current_stock')->default(0);
            $table->integer('min_stock')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
