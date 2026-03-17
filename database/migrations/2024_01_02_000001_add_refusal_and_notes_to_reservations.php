<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->text('refusal_reason')->nullable()->after('confirmation_code');
            $table->text('admin_notes')->nullable()->after('refusal_reason');
            $table->date('actual_return_date')->nullable()->after('return_date');
            $table->enum('book_condition', ['good', 'damaged', 'lost'])->nullable()->after('actual_return_date');
            $table->date('start_date')->nullable()->after('reservation_date');
            $table->date('end_date')->nullable()->after('start_date');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['refusal_reason', 'admin_notes', 'actual_return_date', 'book_condition', 'start_date', 'end_date']);
        });
    }
};
