<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel users. Jika user dihapus, notifikasinya ikut terhapus (cascade)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('title', 255); // Isi pesan notifikasi
            $table->string('icon', 50)->default('edit_note'); // Identifikasi nama ikon untuk Flutter
            $table->string('icon_color', 30)->default('neutral'); // Identifikasi nama warna untuk Flutter
            $table->boolean('is_read')->default(false); // Status apakah user sudah klik/baca
            
            $table->timestamps(); // Menghasilkan kolom 'created_at' dan 'updated_at'
            
            // Indeks pencarian agar query database cepat saat data sudah ribuan
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};