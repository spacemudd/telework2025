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
            $table->boolean('subscription_active')->default(false)->after('remember_token');
            $table->string('subscription_plan')->nullable()->after('subscription_active');
            $table->timestamp('subscription_started_at')->nullable()->after('subscription_plan');
            $table->timestamp('subscription_ends_at')->nullable()->after('subscription_started_at');
            $table->string('last_payment_reference')->nullable()->after('subscription_ends_at');
            $table->timestamp('last_payment_date')->nullable()->after('last_payment_reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'subscription_active',
                'subscription_plan',
                'subscription_started_at',
                'subscription_ends_at',
                'last_payment_reference',
                'last_payment_date'
            ]);
        });
    }
};
