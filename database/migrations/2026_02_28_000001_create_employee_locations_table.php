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
        Schema::create('employee_locations', function (Blueprint $col) {
            $col->id();
            $col->foreignId('user_id')->constrained()->onDelete('cascade');
            $col->decimal('latitude', 10, 8);
            $col->decimal('longitude', 11, 8);
            $col->timestamp('recorded_at')->useCurrent();
            $col->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_locations');
    }
};
