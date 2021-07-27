<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->references('id')->on('products')->onUpdate('no action')->onDelete('set null');
            $table->foreignId('sale_id')->nullable()->references('id')->on('sales')->onUpdate('no action')->onDelete('set null');
            $table->decimal('unit_price', 10, 2);
            $table->integer('quantity')->unsigned()->lenght(11);
            $table->decimal('amount', 10, 2)->unsigned();
            $table->timestamps();
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
        Schema::dropIfExists('sale_details');
        Schema::enableForeignKeyConstraints();
    }
}
