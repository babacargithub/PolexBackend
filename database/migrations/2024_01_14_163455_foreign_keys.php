<?php

use App\Models\Commune;
use App\Models\Membre;
use App\Models\Structure;
use App\Models\TypeCarteMembre;
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
        Schema::table('membres', function (Blueprint $table) {
            $table->foreignIdFor(Structure::class)->nullable()->constrained()->onDelete('cascade');
        });
        Schema::table('structures', function (Blueprint $table) {
            $table->foreignIdFor(Membre::class)->nullable()->constrained()->onDelete('set null');
            $table->foreignIdFor(Commune::class)->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table("members", function (Blueprint $table) {
            $table->dropForeignIdFor(Structure::class);
        });
        Schema::table("structures", function (Blueprint $table) {
            $table->dropForeignIdFor(Membre::class);
            $table->dropUnique(['nom', 'commune']);
        });
    }
};
