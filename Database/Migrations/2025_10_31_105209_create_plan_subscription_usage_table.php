<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanSubscriptionUsageTable extends Migration
{
  

    public function up(): void
    {
        
        if (!Schema::hasTable('memberships_usage'))
        Schema::create("memberships_usage", function (Blueprint $table): void {
            $table->id();

            $table->unsignedBigInteger('subscription_id');
            $table->unsignedBigInteger('feature_id');

            $table->unsignedSmallInteger('used');
            $table->string('timezone')->nullable();

            $table->dateTime('valid_until')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }


    public function down(): void
    {

        if (Schema::hasTable('memberships_usage'))
        Schema::dropIfExists("memberships_usage");

    }

}
