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
            $table->string('role')->default('admin')->after('password')->index();
            $table->string('payment_status')->default('paid')->after('role')->index();
            $table->timestamp('paid_at')->nullable()->after('payment_status');
            $table->boolean('is_active')->default(true)->after('paid_at')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'payment_status', 'paid_at', 'is_active']);
        });
    }
};
