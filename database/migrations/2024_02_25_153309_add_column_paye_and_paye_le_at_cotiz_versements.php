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
    public function up(): void
    {
        //
        Schema::table('cotiz_versements', function (Blueprint $table) {
            $table->boolean("paye")->default(false);
            $table->dateTime("paye_le")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        //
        Schema::table('cotiz_versements', function (Blueprint $table) {
            $table->dropColumn("paye");
            $table->dropColumn("paye_le");
        });
    }
};
