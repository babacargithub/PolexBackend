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
        if (!Schema::hasColumn('pv_bureaux', 'region_id')) {
            Schema::table('pv_bureaux', function (Blueprint $table) {
                $table->foreignIdFor(Region::class)->nullable()->constrained('regions')->onDelete('set null');
            });
        }
        if (!Schema::hasColumn('pv_bureaux', 'departement_id')) {
            Schema::table('pv_bureaux', function (Blueprint $table) {
                $table->foreignIdFor(Departement::class)->nullable()->constrained('departements')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropColumns('pv_bureaux', ['region_id','departement_id']);
    }
};
