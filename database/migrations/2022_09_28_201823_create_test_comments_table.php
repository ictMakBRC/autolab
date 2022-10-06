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
        Schema::create('test_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->longText('comment')->nullable();
            $table->foreignId('created_by')->references('id')->on('users')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->unsignedBigInteger('creator_lab')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_comments');
    }
};
