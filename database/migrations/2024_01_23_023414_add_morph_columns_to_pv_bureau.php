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
    public function up()
    {
        Schema::table('pv_bureaux', function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor(Bureau::class);
            $table->morphs('typeable');
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pv_bureaux', function (Blueprint $table) {
            $table->foreignIdFor(Bureau::class)->nullable(false)->unique()->constrained('bureaux')->onDelete('cascade');
            $table->dropMorphs('typeable');
        });
    }
};
