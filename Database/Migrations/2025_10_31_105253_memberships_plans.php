<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Laravelcm\Subscriptions\Interval;

class MembershipsPlans extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('memberships_plans')) {
            Schema::create("memberships_plans", function (Blueprint $table): void {

                $table->id();

                // Translatable felter som JSON
                $table->json('title')->nullable();
                $table->json('description')->nullable();

                $table->string('slug');

                
                $table->decimal('price', 10, 2)->default('0.00');
                $table->decimal('signup_fee', 10, 2)->default('0.00');
                $table->string('currency', 3)->default('DKK');

                $table->boolean('permanent_membership')->default(false);
                
                $table->boolean('auto_renew')->default(false);

                
                $table->boolean('has_trial')->default(false);
                $table->unsignedSmallInteger('trial_period')->default(0);
                $table->string('trial_interval')->default(Interval::DAY->value);
                $table->boolean('trial_auto_upgrade')->default(false);
                $table->unsignedSmallInteger('invoice_period')->default(0);
                $table->string('invoice_interval')->default(Interval::MONTH->value);
                $table->unsignedSmallInteger('grace_period')->default(0);
                $table->string('grace_interval')->default(Interval::DAY->value);

                $table->unsignedTinyInteger('prorate_day')->nullable();
                $table->unsignedTinyInteger('prorate_period')->nullable();
                $table->unsignedTinyInteger('prorate_extend_due')->nullable();
                $table->unsignedSmallInteger('active_subscribers_limit')->nullable();
                $table->boolean('active')->default(true);
                $table->integer('sorting')->default(1);


                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists("memberships_plans");
    }
}
