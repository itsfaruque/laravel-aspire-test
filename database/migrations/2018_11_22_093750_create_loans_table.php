<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->integer('amount')->nullable(false);
            $table->integer('duration')->nullable(false);
            $table->enum('repayment_frequency', ['weekly','fortnightly','monthly'])->default('monthly');
            $table->integer('interest_rate')->nullable(false);
            $table->integer('arrangement_fee')->nullable(false);
            $table->enum('status', ['processing', 'open', 'closed'])->default('processing');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}