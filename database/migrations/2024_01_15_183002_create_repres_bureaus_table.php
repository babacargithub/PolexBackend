<?php

use App\Models\Bureau;
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
        Schema::create('repres_bureaux', function (Blueprint $table) {
            $table->id();
            $table->string('prenom')->nullable(false);
            $table->string('nom')->nullable(false);
            $table->bigInteger("telephone")->nullable()->unique();
            $table->integer('num_electeur')->nullable()->unique();
            $table->string('parti')->nullable();
            $table->foreignIdFor(Bureau::class)->nullable(false)->constrained("bureaux")->onDelete('cascade');
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
        Schema::dropIfExists('repres_bureaux');
    }
};
