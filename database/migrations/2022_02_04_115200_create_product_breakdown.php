<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductBreakdown extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('product_breakdown', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_from')->unsigned()->references('id')->on('products')->onUpdate('no action')->onDelete('set null');;
            $table->bigInteger('product_to')->unsigned()->references('id')->on('products')->onUpdate('no action')->onDelete('set null');;
            $table->integer('quantity_to_breakdown');
            $table->integer('quantity_to_add');
            $table->bigInteger('created_by')->unsigned()->references('id')->on('users')->onUpdate('no action')->onDelete('set null');
            $table->bigInteger('updated_by')->unsigned()->references('id')->on('users')->onUpdate('no action')->onDelete('set null');
            $table->timestamps();

            $table->index('product_from');
            $table->index('product_to');
            $table->index('quantity_to_breakdown');
            $table->index('quantity_to_add');
            $table->index(['product_from', 'product_to']);
            $table->index('created_by');


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
        Schema::dropIfExists('product_breakdown');
        Schema::enableForeignKeyConstraints();
    }
}
