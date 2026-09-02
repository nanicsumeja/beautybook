<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->decimal('advance_amount', 8, 2)
                ->default(0)
                ->after('total_price');

            $table->string('payment_method')
                ->nullable()
                ->after('advance_amount');

            $table->timestamp('paid_at')
                ->nullable()
                ->after('payment_status');

            $table->index('payment_status');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropIndex([
                'reservations_payment_status_index',
            ]);

            $table->dropColumn([
                'advance_amount',
                'payment_method',
                'paid_at',
            ]);
        });
    }
};