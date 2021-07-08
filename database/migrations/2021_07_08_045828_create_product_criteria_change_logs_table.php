<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCriteriaChangeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('product_criteria_change_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->references('id')->on('products');
            $table->string('criteria_name', 128);
            $table->date('used_date');
            $table->decimal('value_from', 10, 2)->unsigned();
            $table->decimal('value_to', 10, 2)->unsigned();
            $table->timestamps();

            $table->index('product_id');
            $table->index('criteria_name');
            $table->index('used_date');

            $table->index(['product_id', 'criteria_name'], 'pccl_pid_cn');
            $table->index(['product_id', 'criteria_name', 'used_date'], 'pccl_pid_cn_ud');

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
        Schema::dropIfExists('product_criteria_change_logs');
        Schema::enableForeignKeyConstraints();
    }
}
