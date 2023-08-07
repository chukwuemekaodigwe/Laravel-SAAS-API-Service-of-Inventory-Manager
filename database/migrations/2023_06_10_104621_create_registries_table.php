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
        Schema::create('registries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('company_id')->nullable();
            $table->bigInteger('branch_id')->nullable();
            $table->decimal('cash_sales', 25, 6)->nullable();
            $table->bigInteger('opened_by')->nullable();
            $table->bigInteger('closed_by')->nullable();
            $table->dateTime('time_opened')->nullable();
            $table->dateTime('time_closed')->nullable();
            $table->decimal('opening_amt', 25, 6)->nullable()->default(0);
            $table->decimal('closing_amt', 25, 6)->nullable()->default(0);
            $table->string('reg_code')->nullable()->default(0);
            $table->decimal('total_exp', 25, 6)->nullable()->default(0);
            $table->decimal('total_income', 25, 6)->nullable()->default(0);
            $table->decimal('total_sales', 25, 6)->nullable()->default(0);
            $table->decimal('bank_sales', 25, 6)->nullable()->default(0);
            $table->decimal('cheque_sales', 25, 6)->nullable()->default(0);
            $table->decimal('debts', 25, 6)->nullable()->default(0);
            $table->decimal('receive_payments', 25, 6)->nullable()->default(0);
            $table->decimal('returns', 25, 6)->nullable()->default(0);
            $table->decimal('expenses', 25, 6)->nullable()->default(0);
            $table->decimal('incomes', 25, 6)->nullable()->default(0);
            $table->integer('status')->nullable()->default(0);
            $table->decimal('transfer', 25, 6)->nullable()->default(0);
            $table->tinyText('opening_note')->nullable();
            $table->tinyText('closing_note')->nullable();
            
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registries');
    }
};
