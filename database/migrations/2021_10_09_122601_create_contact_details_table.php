<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('mobile_no')->nullable();
            $table->string('p_address')->nullable();
            $table->string('p_city')->nullable();
            $table->bigInteger('p_pincode')->nullable();
            $table->string('p_state')->nullable();
            $table->string('p_contrary')->nullable();
            $table->string('n_address')->nullable();
            $table->string('n_city')->nullable();
            $table->bigInteger('n_pincode')->nullable();
            $table->string('n_state')->nullable();
            $table->string('n_contrary')->nullable();
            $table->boolean('both_address_same')->default(false);
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
        Schema::dropIfExists('contact_details');
    }
}
