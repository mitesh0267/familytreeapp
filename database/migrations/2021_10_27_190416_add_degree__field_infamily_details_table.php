<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDegreeFieldInfamilyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('family_details', function (Blueprint $table) {
            $table->string('b_degree_name')->after('b_degree')->nullable();
            $table->string('m_degree_name')->after('m_degree')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('family_details', function (Blueprint $table) {
            //
        });
    }
}
