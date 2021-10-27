<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHeightPhysicalDisabilityBooldGroupColumnsToFamilyDetailsNodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('family_details')) {
            Schema::table('family_details', function (Blueprint $table) {
                $table->string('height')->nullable()->after('married_status');
                $table->boolean('physical_disability')->default(false)->after('height');
                $table->string('blood_group')->nullable()->after('physical_disability');
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
        if (Schema::hasTable('family_details')) {
            Schema::table('family_details', function (Blueprint $table) {
                $table->dropIndex('height');	
                $table->dropIndex('physical_disability');	
                $table->dropIndex('blood_group');				
            });
        }
    }
}
