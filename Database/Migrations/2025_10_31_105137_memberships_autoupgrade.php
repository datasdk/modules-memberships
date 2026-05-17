<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MembershipsAutoupgrade extends Migration
{

     public function up()
    {
        if (!Schema::hasTable('memberships_autoupgrade')) {
            Schema::create('memberships_autoupgrade', function (Blueprint $table) {
                $table->id();
                $table->foreignId('plan_id');
                $table->string('event', 200);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memberships_autoupgrade');
    }

}
