<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting_name',512);
            $table->string('setting_value', 512);
            $table->timestamps();

            $table->index('setting_name');
            $table->index('setting_value');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('system_settings');
        Schema::enableForeignKeyConstraints();
    }
}
