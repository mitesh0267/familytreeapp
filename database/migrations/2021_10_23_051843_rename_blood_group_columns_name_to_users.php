<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameBloodGroupColumnsNameToUsers extends Migration
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
                DB::statement('ALTER TABLE `users` CHANGE `boold_group` `blood_group` VARCHAR(255)  NULL;');
            });
        }
        if (Schema::hasTable('contact_details')) {
            Schema::table('contact_details', function (Blueprint $table) { 
                DB::statement('ALTER TABLE `contact_details` CHANGE `p_contrary` `p_country` VARCHAR(255)  NULL;');
                DB::statement('ALTER TABLE `contact_details` CHANGE `n_contrary` `n_country` VARCHAR(255)  NULL;');

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
    
    }
}
