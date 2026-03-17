<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('role');
            $table->integer('total_reservations')->default(0)->after('notes');
            $table->integer('on_time_returns')->default(0)->after('total_reservations');
            $table->integer('late_returns')->default(0)->after('on_time_returns');
            $table->integer('damaged_books')->default(0)->after('late_returns');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['notes', 'total_reservations', 'on_time_returns', 'late_returns', 'damaged_books']);
        });
    }
};
