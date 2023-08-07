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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('plan_id')->nullable();
            $table->string('referenceNo')->nullable();
            $table->string('paymentRef')->nullable();
            $table->decimal('amount', 20,3)->nullable();
            $table->string('agent_id')->nullable();
            $table->string('company_id')->nullable();
            $table->string('durationInMonth')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('status')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
