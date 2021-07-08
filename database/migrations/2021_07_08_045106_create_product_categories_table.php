<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 256);
            $table->enum('status', ['active','inactive'])->default('active');
            $table->timestamps();

            $table->index('name');
            $table->index('status');
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
        Schema::dropIfExists('product_categories');
        Schema::enableForeignKeyConstraints();

    }
}
