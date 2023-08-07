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
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('order_id')->nullable();
            $table->bigInteger('company_id')->nullable();
            $table->bigInteger('branch_id')->nullable();
            $table->bigInteger('employee')->nullable();
            $table->decimal('amount_repaid', 20, 4)->nullable();
            $table->bigInteger('customer_id')->nullable();
            $table->string('order_no')->nullable();
            $table->tinyText('details')->nullable()->comment('product_id returned and qty');
            $table->string('payment_method')->nullable();
            $table->string('reason')->nullable();
            $table->boolean('stockBehaviour')->nullable()->comment('if stock should return to stock or diecarded');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
