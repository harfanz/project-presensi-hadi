<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konfigurasi_lokasi', function (Blueprint $table) {
            $table->id();
            $table->string('lokasi_kantor', 255)->default('-6.170984246980753,106.82988193399835');
            $table->smallInteger('radius')->default(0);
        });

        // Data default
        DB::table('konfigurasi_lokasi')->insert([
            'id' => 1,
            'lokasi_kantor' => '-6.170984246980753,106.82988193399835',
            'radius' => 2000,
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('konfigurasi_lokasi');
    }
};
