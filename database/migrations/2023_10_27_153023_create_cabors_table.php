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
        Schema::create(config('apptra.database.prefix') . 'cabor', function (Blueprint $table) {
            $table->id();
            $table->string('cabor_name');
            $table->string('initial');
            $table->string('logo')->nullable()->default('img/default-avatar.jpg');
            $table->date('date_founded')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('apptra.database.prefix') . 'cabor');
    }
};
