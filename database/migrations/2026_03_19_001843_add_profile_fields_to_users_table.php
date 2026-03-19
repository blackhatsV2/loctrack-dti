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
        Schema::table('users', function (Blueprint $table) {
            $table->string('employee_id_no')->nullable()->after('email');
            $table->string('mobile_no')->nullable()->after('employee_id_no');
            $table->string('office')->nullable()->after('mobile_no');
            $table->string('employee_type')->nullable()->after('office');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['employee_id_no', 'mobile_no', 'office', 'employee_type']);
        });
    }
};
