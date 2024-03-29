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
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sample_id');
            $table->unsignedBigInteger('test_id');
            $table->string('result')->nullable();
            $table->string('attachment')->nullable();
            $table->text('parameters')->nullable();
            $table->foreignId('kit_id')->nullable();
            $table->string('verified_lot')->nullable();
            $table->date('kit_expiry_date')->nullable();
            $table->unsignedBigInteger('performed_by')->nullable();
            $table->text('comment')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->text('reviewer_comment')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->text('approver_comment')->nullable();
            $table->dateTime('reviewed_at')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->string('status')->nullable();
            $table->string('tracker', 40)->nullable();
            $table->integer('download_count')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
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
        Schema::dropIfExists('test_results');
    }
};
