<?php

use App\Models\Centre;
use App\Models\Commune;
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
        Schema::create('centres', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable(false);
            $table->unique(['nom', 'commune_id']);
            $table->foreignIdFor(Commune::class)->nullable(false)->constrained();

        });
        Schema::create('bureaux', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable(false);
            $table->integer('nombre_inscrits')->nullable();
            $table->unique(['nom', 'centre_id']);
            $table->foreignIdFor(Centre::class)->nullable(false)->constrained()->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('centres');
        Schema::dropIfExists('bureaux');
    }
};
