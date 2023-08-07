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
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->float('costprice', 15, 2)->nullable();
            $table->float('sellingprice', 15, 2)->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('company_id');
            $table->string('brief_note')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('ended_by');
            $table->integer('status')->nullable()->comment('1 == active, 2 == suspended');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_prices');
    }
};
