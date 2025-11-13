<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->char('id_pkl', 5)->primary();
            $table->string('nama_lengkap', 100);
            $table->string('sekolah',20);
            $table->string('no_hp',13);
            $table->string('foto',255)->nullable();
            $table->char('kode_dept', 5);
            $table->string('password', 100);
            $table->string('remember_token', 255)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
