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
            $table->foreignId('tour_package_id')->nullable()->constrained()->nullOnDelete();
            $table->string('visitor_name');
            $table->string('email');
            $table->string('phone', 30);
            $table->date('reservation_date')->index();
            $table->unsignedInteger('total_people');
            $table->text('notes')->nullable();
            $table->string('status')->default('pending')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
