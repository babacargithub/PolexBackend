<?php

use App\Models\Centre;
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
            $table->integer('inscrits')->nullable(false);
            $table->integer('votants')->nullable(false);
            $table->integer('suffrages_exprimes')->nullable(false);
            $table->integer('bulletins_nuls')->nullable(false);
            $table->boolean('certifie')->default(false);
            $table->timestamps();
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
        Schema::dropIfExists('resultat_centres');
    }
};
