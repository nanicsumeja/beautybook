<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('service_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('employee_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
             * Čuvamo naziv, cijenu i trajanje kakvi su bili
             * u trenutku rezervacije.
             */
            $table->string('service_name');
            $table->unsignedSmallInteger('duration_minutes');
            $table->decimal('total_price', 8, 2);

            $table->date('appointment_date');
            $table->time('start_time');
            $table->time('end_time');

            $table->enum('status', [
                'pending',
                'confirmed',
                'completed',
                'cancelled',
            ])->default('pending');

            $table->enum('payment_status', [
                'pending',
                'paid',
                'refunded',
            ])->default('pending');

            $table->string('payment_reference')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();

            $table->index([
                'appointment_date',
                'start_time',
            ]);

            $table->index([
                'employee_id',
                'appointment_date',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};