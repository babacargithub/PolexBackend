<?php

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
        Schema::table('carte_membres', function (Blueprint $table) {
           $table->dateTime(("vendu_le"))->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('carte_membres', function (Blueprint $table) {
            $table->dropColumn("vendu_le");
        });
    }
};
