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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title')->nullable();
            $table->integer('transactions')->nullable();
            $table->integer('users')->nullable();
            $table->integer('branches')->nullable();
            $table->integer('auditor')->nullable();
            $table->boolean('exportable')->nullable();
            $table->integer('status')->nullable();
            $table->tinyText('misc')->nullable();
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
