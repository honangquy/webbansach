<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flash_sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flash_sale_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->decimal('flash_price', 10, 2);
            $table->integer('stock_quantity')->default(0);
            $table->integer('sold_quantity')->default(0);
            $table->timestamps();
            
            $table->unique(['flash_sale_id', 'book_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flash_sale_items');
    }
};
