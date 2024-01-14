<?php

use App\Models\Departement;
use App\Models\Region;
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
        //
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable(false)->unique();

        });
        Schema::create('departements', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable(false)->unique();
            $table->foreignIdFor(Region::class)->nullable(false)->constrained()->onDelete('cascade');

        });
        Schema::create('communes', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable(false)->unique();
            $table->foreignIdFor(Departement::class)->nullable(false)->constrained()->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        //
        Schema::dropIfExists("communes");
        Schema::dropIfExists("departement");
        Schema::dropIfExists("regions");
    }
};
