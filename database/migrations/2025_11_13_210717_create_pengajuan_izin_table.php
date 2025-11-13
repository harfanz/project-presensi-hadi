<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_izin', function (Blueprint $table) {
            $table->id();
            $table->char('id_pkl', 5);
            $table->date('tgl_izin');
            $table->char('status', 1);
            $table->string('keterangan', 255);
            $table->char('status_approved', 1)->default('0');
            $table->string('tanda_bukti', 255)->nullable();
            $table->string('balasan', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_izin');
    }
};
