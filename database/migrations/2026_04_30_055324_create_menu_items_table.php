<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('menu_items', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('category');
        $table->text('description')->nullable();
        $table->decimal('price', 8, 2);
        $table->string('emoji')->nullable();
        $table->boolean('available')->default(true);
        $table->timestamps();
    });
}
};
