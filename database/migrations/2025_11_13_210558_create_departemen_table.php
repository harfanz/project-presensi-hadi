<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departemen', function (Blueprint $table) {
            $table->char('kode_dept', 5)->primary();
            $table->string('nama_dept', 20);
        });

        // Tambahkan data default departemen jika mau
        DB::table('departemen')->insert([
            ['kode_dept' => 'D001', 'nama_dept' => 'HRD'],
            ['kode_dept' => 'D002', 'nama_dept' => 'Keuangan'],
            ['kode_dept' => 'D003', 'nama_dept' => 'IT'],
            ['kode_dept' => 'D004', 'nama_dept' => 'Produksi'],
        ]);
    }   

    public function down(): void
    {
        Schema::dropIfExists('departemen');
    }
};
