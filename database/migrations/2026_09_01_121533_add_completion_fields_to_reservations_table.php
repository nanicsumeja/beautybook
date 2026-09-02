<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->timestamp('completed_at')
                ->nullable()
                ->after('paid_at');

            $table->text('employee_note')
                ->nullable()
                ->after('completed_at');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn([
                'completed_at',
                'employee_note',
            ]);
        });
    }
};