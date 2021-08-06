<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->references('id')->on('products')->onUpdate('no action')->onDelete('set null');
            $table->foreignId('purchase_id')->nullable()->references('id')->on('purchases')->onUpdate('no action')->onDelete('cascade');
            $table->string('product_code', 512);
            $table->string('measure_unit', 512);
            $table->integer('quantity')->unsigned()->length(11);
            $table->timestamps();


            $table->index('measure_unit');
            $table->index('created_at');
            $table->index('updated_at');

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
        Schema::dropIfExists('purchase_details');
        Schema::enableForeignKeyConstraints();
    }
}
