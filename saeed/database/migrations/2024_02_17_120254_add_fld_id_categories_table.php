<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFldIdCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->bigInteger('fldId')->unique()->nullable()->after('id');
            $table->bigInteger('groupId')->nullable()->after('fldId');
            $table->bigInteger('fldC_M_GroohKala')->nullable()->after('groupId');
            $table->bigInteger('fldC_S_GroohKala')->nullable()->after('fldC_M_GroohKala');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            //
        });
    }
}
