<?php

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
        Schema::table('membre_comite_electorals', function (Blueprint $table) {
            //
            $table->foreignIdFor(\App\Models\ComiteRole::class)->nullable()->constrained()->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('membre_comite_electorals', function (Blueprint $table) {
            //
            $table->dropForeign(['comite_role_id']);
            $table->dropColumn('comite_role_id');
        });
    }
};
