<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHeightPhysicalDisabilityBooldGroupColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('height')->nullable()->after('professional');
                $table->boolean('physical_disability')->default(false)->after('mobile_no');
                $table->string('boold_group')->nullable()->after('physical_disability');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropIndex('height');	
                $table->dropIndex('physical_disability');	
                $table->dropIndex('boold_group');				
            });
        }
    }
}
