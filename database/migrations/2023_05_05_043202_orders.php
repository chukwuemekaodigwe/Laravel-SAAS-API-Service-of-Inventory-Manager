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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('order_no')->unique();
            $table->string('invoice_no')->nullable();
            $table->string('status')->comment('status 1 = ordered, 2 = paid, 3 = supplied')->default(1);
            $table->bigInteger('user_id')->comment('the sales personnel')->nullable();
            $table->bigInteger('customer_id')->comment('customer detail')->nullable();
            $table->bigInteger('company_id')->nullable();
            $table->decimal('total', 20,4)->nullable();
            $table->decimal('amount_paid', 20,4)->nullable();
            $table->decimal('remainder', 20,4)->nullable();
            $table->decimal('discount', 5,5)->nullable();
            $table->decimal('tax', 5, 5)->nullable();
            $table->date('ledger_date')->nullable();
            $table->decimal('total_payable', 20, 4)->nullable();
            $table->string('payments')->comment('cash, card/pos, banktransfer')->nullable();
            $table->bigInteger('branch_id')->nullable();
            $table->bigInteger('registry_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
