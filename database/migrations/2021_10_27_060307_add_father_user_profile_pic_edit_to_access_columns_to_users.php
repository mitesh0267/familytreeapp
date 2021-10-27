<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFatherUserProfilePicEditToAccessColumnsToUsers extends Migration
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
                $table->string('father_profile_pic')->nullable()->after('father_name');
                $table->string('user_profile_pic')->nullable()->after('name');
                $table->boolean('edit_to_access')->default(false)->after('role');
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
                $table->dropIndex('father_profile_pic');	
                $table->dropIndex('user_profile_pic');	
                $table->dropIndex('edit_to_access');				
            });
        }
    }
}
