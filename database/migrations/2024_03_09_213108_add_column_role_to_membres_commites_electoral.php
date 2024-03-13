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
            $table->string('role')->default(null);
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
            $table->dropColumn('role');
        });
    }
};
