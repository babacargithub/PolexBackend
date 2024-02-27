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
        Schema::table('organigrammes', function (Blueprint $table) {
            //parent_id, lft, rgt, depth
            $table->integer('parent_id')->nullable()->default(0);
            $table->integer('lft')->nullable()->default(0);
            $table->integer('rgt')->nullable()->default(0);
            $table->integer('depth')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('organigrammes', function (Blueprint $table) {
            //
            $table->dropColumn('parent_id');
            $table->dropColumn('lft');
            $table->dropColumn('rgt');
            $table->dropColumn('depth');
        });
    }
};
