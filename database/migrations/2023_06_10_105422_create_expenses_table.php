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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->decimal('amount', 20,4)->nullable();
            $table->bigInteger('employee')->nullable();
            $table->bigInteger('company_id')->nullable();
            $table->bigInteger('branch_id')->nullable();
            $table->bigInteger('registry_id')->nullable();
            $table->string('type')->nullable();
            $table->string('payment_method')->nullable()->comment('1=cash, 2=ATM, 3=Bank, 4=Online Payment; 5=Other');
            $table->text('misc')->nullable();
            $table->date('ledger_date')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
