<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToAquariumDataTable extends Migration
{
    public function up()
    {
        Schema::table('aquarium_data', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('aquarium_data', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
