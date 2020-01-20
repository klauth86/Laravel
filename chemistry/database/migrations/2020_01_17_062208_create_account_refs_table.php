<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountRefsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_orm_account_refs', function (Blueprint $table) {
            $table->increments('id');
			$table->string('facebook_login', 127);
            $table->string('reference', 127);			
			$table->boolean('is_telegram');
			$table->boolean('is_active')->default(true);
			$table->foreign('facebook_login')->references('facebook_login')->on('t_orm_account');	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_orm_account_refs');
    }
}
