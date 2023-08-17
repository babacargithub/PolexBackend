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
        //
        Schema::table('formules', function (Blueprint $table) {
            $table->string("nom")->nullable(false);
            $table->string("constant_name")->unique();
            $table->integer("prix")->nullable(false);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('formules', function (Blueprint $table) {
            $table->dropColumn("nom");
            $table->dropColumn("constant_name");
            $table->dropColumn("prix");

        });
    }
};
