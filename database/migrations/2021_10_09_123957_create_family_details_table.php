<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name')->nullable();
            $table->string('relation')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('profile_pic')->nullable();
            $table->enum('married_status', ['married','unmarried'])->nullable()->default(null);
            $table->string('school_name_1')->nullable();
            $table->string('school_name_2')->nullable();
            $table->boolean('both_school_same')->default(false);
            $table->boolean('b_degree')->default(false);
            $table->string('b_college_name')->nullable();
            $table->boolean('m_degree')->default(false);
            $table->string('m_college_name')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('family_details');
    }
}
