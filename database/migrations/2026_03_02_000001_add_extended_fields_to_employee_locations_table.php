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
        Schema::table('employee_locations', function (Blueprint $col) {
            $col->string('employee_id_no')->nullable()->after('user_id');
            $col->string('address')->nullable()->after('employee_id_no');
            $col->string('mobile_no')->nullable()->after('longitude');
            $col->string('office')->nullable()->after('mobile_no');
            $col->string('employee_type')->nullable()->after('office');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_locations', function (Blueprint $col) {
            $col->dropColumn(['employee_id_no', 'address', 'mobile_no', 'office', 'employee_type']);
        });
    }
};
