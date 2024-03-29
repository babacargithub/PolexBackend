<?php

use App\Models\Candidat;
use App\Models\Centre;
use App\Models\PvCentre;
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
        Schema::create('resultat_centres', function (Blueprint $table) {
            $table->id();
            $table->integer("nombre_voix")->nullable(false);
            $table->foreignIdFor(PvCentre::class)->nullable(false)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Candidat::class)->nullable(false)->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('resultat_centres');
    }
};
