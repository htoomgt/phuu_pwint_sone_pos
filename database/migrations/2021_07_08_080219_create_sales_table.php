<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::disableForeignKeyConstraints();
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('voucher_number')->unsigned()->nullable();
            $table->datetime('sold_at');
            $table->string('customer_name', 512)->nullable();
            $table->string('customer_phone', 512)->nullable();
            $table->foreignId('sold_by')->nullable()->references('id')->on('users')->onUpdate('no action')->onDelete('set null');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('grand_total', 10,2);
            $table->timestamps();

            $table->index('voucher_number');
            $table->index('sold_at');
            $table->index('sold_by');

            $table->index(['sold_at', 'sold_by']);
            $table->index(['voucher_number', 'sold_at']);
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
        Schema::dropIfExists('sales');
        Schema::enableForeignKeyConstraints();
    }
}
