<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Prvo privremeno dozvolimo sve vrijednosti.
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('payment_status')->default('unpaid')->change();
        });

        // Sada postojeće "pending" možemo pretvoriti u "unpaid".
        \DB::table('reservations')
            ->where('payment_status', 'pending')
            ->update([
                'payment_status' => 'unpaid',
            ]);

        // Na kraju postavljamo konačni ENUM.
        Schema::table('reservations', function (Blueprint $table) {
            $table->enum('payment_status', [
                'unpaid',
                'paid',
                'failed',
                'refunded',
            ])->default('unpaid')->change();
        });
    }

    public function down(): void
    {
        // Privremeno uklonimo ENUM ograničenje.
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('payment_status')->default('pending')->change();
        });

        // Vratimo unpaid u pending.
        \DB::table('reservations')
            ->where('payment_status', 'unpaid')
            ->update([
                'payment_status' => 'pending',
            ]);

        \DB::table('reservations')
            ->where('payment_status', 'failed')
            ->update([
                'payment_status' => 'pending',
            ]);

        Schema::table('reservations', function (Blueprint $table) {
            $table->enum('payment_status', [
                'pending',
                'paid',
                'refunded',
            ])->default('pending')->change();
        });
    }
};