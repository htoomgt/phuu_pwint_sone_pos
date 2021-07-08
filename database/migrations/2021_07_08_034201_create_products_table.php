<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::disableForeignKeyConstraints();
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 512);
            $table->string('myanmar_name', 512)->nullable();
            $table->enum('status', ['active','inactive'])->default('active');
            $table->foreignId('category_id')->references('id')->on('product_categories');
            $table->string('product_code', 512);
            $table->foreignId('measure_unit_id')->references('id')->on('product_measure_units');
            $table->integer('reorder_level')->unsigned()->length(11);
            $table->decimal('unit_price',10,2)->unsigned();
            $table->decimal('ex-mill_price', 10, 2)->unsigned();
            $table->decimal('transport_fee', 10, 2)->unsigned();
            $table->decimal('unload_fee', 10, 2)->unsigned();
            $table->foreignId('created_by')->references('id')->on('users');
            $table->foreignId('updated_by')->references('id')->on('users')->nullable();
            $table->timestamps();

            $table->index('name');
            $table->index('myanmar_name');
            $table->index('product_code');
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
        Schema::dropIfExists('products');
        Schema::enableForeignKeyConstraints();

    }
}
