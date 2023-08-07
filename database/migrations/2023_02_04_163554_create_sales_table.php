<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('product_id')->nullable();
            $table->decimal('qty', 20,5)->nullable();
            $table->decimal('price', 20, 5)->nullable();
            $table->decimal('cost_price', 20 , 5)->nullable();
            $table->bigInteger('order_id')->nullable();
            $table->string('invoice_no')->nullable();
            $table->bigInteger('company_id')->nullable();
            $table->bigInteger('branch_id')->nullable();
            $table->date('ledger_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
