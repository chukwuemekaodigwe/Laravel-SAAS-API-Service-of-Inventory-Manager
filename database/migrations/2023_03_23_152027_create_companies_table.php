
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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->nullable();
            $table->tinyText('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('logo')->nullable();
            $table->string('currency')->nullable();
            $table->string('timezone')->nullable();
            $table->integer('subscription')->nullable();
            $table->string('color')->nullable();
            $table->string('companyId')->nullable();
            $table->bigInteger('admin')->nullable();
            $table->boolean('registry_by_user')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
