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
            $table->foreignId('category_id')->nullable()->references('id')->on('product_categories')->onUpdate('cascade')->onDelete('set null');
            $table->string('product_code', 512);
            $table->foreignId('measure_unit_id')->nullable()->references('id')->on('product_measure_units')->onUpdate('cascade')->onDelete('set null');
            $table->integer('reorder_level')->unsigned()->length(11);
            $table->decimal('unit_price',10,2)->unsigned();
            $table->decimal('ex_mill_price', 10, 2)->unsigned();
            $table->decimal('transport_fee', 10, 2)->unsigned();
            $table->decimal('unload_fee', 10, 2)->unsigned();
            $table->decimal('original_cost', 10, 2)->unsigned();
            $table->decimal('profit_per_unit', 10, 2)->unsigned();
            $table->foreignId('breakdown_parent')->nullable()->references('id')->on('products')->onUpdate('cascade')->onDelete('set null');
            $table->integer('breadown_parent_full_multiplier')->unsigned()->nullable();


            $table->foreignId('created_by')->nullable()->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
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
