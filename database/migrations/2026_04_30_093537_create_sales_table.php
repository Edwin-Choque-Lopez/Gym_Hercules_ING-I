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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('set null');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('payment_type_id')->nullable()->constrained('payment_types')->onDelete('set null');
            $table->foreignId('discount_id')->nullable()->constrained('discounts')->onDelete('set null');   
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount_payment', 10, 2);
            $table->date('sale_date');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
