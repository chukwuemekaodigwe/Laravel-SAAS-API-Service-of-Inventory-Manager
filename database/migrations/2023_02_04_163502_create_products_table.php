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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('name');
            $table->string('sku')->nullable();
            $table->decimal('sellingprice')->nullable();
            $table->decimal('costprice')->nullable();
            $table->decimal('alert_level')->nullable();
            $table->bigInteger('company_id')->nullable();
            $table->string('image')->nullable();
            $table->integer('type')->comments('! == variableLength product  | 2 = fixedCountable Product')->nullable();
            $table->string('units')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
