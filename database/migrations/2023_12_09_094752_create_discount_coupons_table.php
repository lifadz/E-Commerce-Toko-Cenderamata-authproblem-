<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discount_coupons', function (Blueprint $table) {
            $table->id();

            //kode voucher diskon
            $table->string('code');

            //nama kode voucher diskon
            $table->string('name')->nullable();

            //deskripsi voucher diskon
            $table->text('description')->nullable();

            //maksimal penggunaan voucher
            $table->integer('max_uses')->nullable();

            //berapa banyak user bisa memakai voucher diskon
            $table->integer('max_uses_user')->nullable();

            //voucher diskon adalah potongan harga asli atau persentasi
            $table->enum('type',['percent','fixed'])->default('fixed');

            //jumlah potongan sesuai tipe diskon
            $table->double('discount_amount',10,3);
            
            //jumlah potongan sesuai tipe diskon
            $table->double('min_amount',10,3)->nullable();

            
            $table->integer('status')->default(1);

            //tanggal berlaku voucher
            $table->timestamp('starts_at')->nullable();

            //tanggal voucher kadaluarsa
            $table->timestamp('expires_at')->nullable();

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_coupons');
    }
};