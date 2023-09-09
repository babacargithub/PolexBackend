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
    public function up(): void
    {
        Schema::create('params', function (Blueprint $table) {
            $table->id();
            $table->string('discriminant_field_name');
            $table->json('discriminant_field');
            $table->boolean('check_discriminant');
            $table->integer('min_count');
            $table->integer('max_count');
            $table->integer('count_per_region');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('params');
    }
};
