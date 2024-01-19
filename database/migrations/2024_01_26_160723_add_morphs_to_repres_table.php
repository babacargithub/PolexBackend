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
        Schema::table('repres_bureaux', function (Blueprint $table) {
            if (Schema::hasColumn('repres_bureaux', 'bureau_id')) {
                $table->dropForeignIdFor(Bureau::class);
            }
            if (! Schema::hasColumn('repres_bureaux', 'lieu_vote_type')) {
                $table->morphs('lieu_vote');
                $table->unique(['lieu_vote_id', 'lieu_vote_type']);
            }
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('repres_bureaux', function (Blueprint $table) {
            $table->dropMorphs('lieu_vote');
            //
        });
    }
};
