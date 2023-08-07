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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->decimal('qty', 32 , 5)->nullable();
            $table->integer('type')->nullable()->comment('1 ==> stock, 2 ==> transfer, 3 ==> removal');
            $table->bigInteger('branch_id')->nullable();
            $table->bigInteger('company_id')->nullable();
            $table->bigInteger('registered_by')->nullable();
            $table->bigInteger('received_by')->nullable();
            $table->bigInteger('from')->nullable()->comment('for transfer type. From which branch');
            $table->tinyText('brief_note')->nullable();
            $table->integer('status')->nullable();
            $table->string('stockId')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
};
