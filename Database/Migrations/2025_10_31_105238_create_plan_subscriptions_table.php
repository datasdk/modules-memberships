<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanSubscriptionsTable extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('memberships_subscriptions')) {
            Schema::create('memberships_subscriptions', function (Blueprint $table): void {
                $table->id();

                $table->string('name')->default('main');

                // Erstat morphs med separate kolonner og kort index
                $table->unsignedBigInteger('subscribable_id');
                $table->string('subscribable_type');
                $table->index(['subscribable_type', 'subscribable_id'], 'subs_sub_type_idx');

                $table->unsignedBigInteger('plan_id');

                $table->json('description')->nullable();
                $table->string('timezone')->nullable();

                $table->string('payment_method')->nullable(); // fx "credit_card", "paypal"
                $table->string('payment_status')->nullable(); // fx "pending", "paid", "failed"
                $table->timestamp('paid_at')->nullable();
                


                $table->boolean('has_trial')->default(false);
                $table->boolean('permanent_membership')->default(false);

                $table->dateTime('trial_ends_at')->nullable();
                $table->dateTime('starts_at')->nullable();
                $table->dateTime('ends_at')->nullable();
                $table->boolean('auto_renew')->default(false);

                $table->boolean('trial_auto_upgrade')->default(false);
                $table->dateTime('cancels_at')->nullable();
                $table->dateTime('canceled_at')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('memberships_subscriptions')) {
            Schema::dropIfExists('memberships_subscriptions');
        }
    }
}
