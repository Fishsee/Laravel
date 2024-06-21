<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPumpStateToAquariumTable extends Migration
{
    public function up()
    {
        Schema::table('aquaria', function (Blueprint $table) {
            $table->boolean('pump_state')->default(false);
        });
    }

    public function down()
    {
        Schema::table('aquaria', function (Blueprint $table) {
            $table->dropColumn('pump_state');
        });
    }
}
