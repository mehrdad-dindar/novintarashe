<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('fldId')->nullable()->after('id');
            $table->bigInteger('fldC_Kala')->nullable()->after('fldId');
            $table->string('vahed')->nullable()->after('fldC_Kala');
            $table->string('vahed_kol')->nullable()->after('vahed');
            $table->bigInteger('fldTedadKarton')->nullable()->after('vahed_kol');
            $table->tinyInteger('fldPorForoosh')->default(0)->nullable()->after('fldTedadKarton');
            $table->text('morePrice')->nullable()->after('fldTedadKarton');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {

        });
    }
};
