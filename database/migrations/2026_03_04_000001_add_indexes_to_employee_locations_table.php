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
        Schema::table('employee_locations', function (Blueprint $table) {
            $table->index('recorded_at');
            $table->index('office');
            $table->index('employee_type');
            $table->index(['user_id', 'recorded_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_locations', function (Blueprint $table) {
            $table->dropIndex(['recorded_at']);
            $table->dropIndex(['office']);
            $table->dropIndex(['employee_type']);
            $table->dropIndex(['user_id', 'recorded_at']);
        });
    }
};
