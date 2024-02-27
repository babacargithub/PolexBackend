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
        Schema::create('cotizs', function (Blueprint $table) {
            $table->id();
            $table->integer('montant')->nullable(false);
            $table->string('libelle')->nullable(false)->unique();
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizs');
    }
};
