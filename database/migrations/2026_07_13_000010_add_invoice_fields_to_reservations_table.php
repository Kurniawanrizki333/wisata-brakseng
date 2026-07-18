<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('reservation_code')->nullable()->unique()->after('id');
            $table->decimal('total_price', 12, 2)->default(0)->after('total_people');
            $table->string('payment_method')->default('bank_transfer')->after('notes');
            $table->string('payment_status')->default('unpaid')->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['reservation_code', 'total_price', 'payment_method', 'payment_status']);
        });
    }
};
