<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreteSosmedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_unit', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('group_name',191)->nullable();
            $table->string('logo',191)->nullable();
            $table->string('insert_user',191)->nullable();
            $table->string('update_user',191)->nullable();
            $table->timestamps();
        });

        Schema::create('business_unit', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('group_unit_id',191)->nullable();
            $table->string('unit_name',191)->nullable();
            $table->string('logo',191)->nullable();
            $table->string('insert_user',191)->nullable();
            $table->string('update_user',191)->nullable();
            $table->timestamps();

            $table->foreign('group_unit_id')
                ->references('id')
                ->on('group_unit')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('program_unit', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('business_unit_id',191)->nullable();
            $table->string('program_name',191)->nullable();
            $table->string('insert_user',191)->nullable();
            $table->string('update_user',191)->nullable();
            $table->timestamps();

            $table->foreign('business_unit_id')
                ->references('id')
                ->on('business_unit')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('sosmed', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('sosmed_name',191)->nullable();
            $table->string('logo',191)->nullable();
            $table->string('insert_user',191)->nullable();
            $table->string('update_user',191)->nullable();
            $table->timestamps();
        });

        Schema::create('unit_sosmed', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->enum('type_sosmed',['corporate','program'])->nullable();
            $table->integer('business_program_unit')->unsigned()->nullable();
            $table->integer('sosmed_id')->unsigned()->nullable();
            $table->string('unit_sosmed_name',191)->nullable();
            $table->integer('target_use')->unsigned()->nullable();
            $table->string('insert_user',191)->nullable();
            $table->string('update_user',191)->nullable();
            $table->timestamps();

            $table->foreign('sosmed_id')
                ->references('id')
                ->on('sosmed')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

        Schema::create('unit_sosmed_follower', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('unit_sosmed_id')->unsigned()->nullable();
            $table->date('tanggal')->nullable();
            $table->string('follower',191)->nullable();
            $table->string('insert_user',191)->nullable();
            $table->string('update_user',191)->nullable();
            $table->timestamps();

            $table->foreign('unit_sosmed_id')
                ->references('id')
                ->on('unit_sosmed')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

        Schema::create('unit_sosmed_target',function(Blueprint $table){
            $table->increments('id')->unsigned();
            $table->integer('unit_sosmed_id')->unsigned()->nullable();
            $table->year('tahun')->nullable();
            $table->float('target')->nullable();
            $table->timestamps();

            $table->foreign('unit_sosmed_id')
                ->references('id')
                ->on('unit_sosmed')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

        Schema::table('unit_sosmed', function (Blueprint $table) {
            $table->foreign('target_use')
                ->references('id')
                ->on('unit_sosmed_target')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
