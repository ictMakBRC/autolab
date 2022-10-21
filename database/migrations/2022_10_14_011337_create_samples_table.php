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
        Schema::create('samples', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('participant_id');
            $table->unsignedBigInteger('sample_type_id');
            $table->string('sample_no');
            $table->string('sample_identity');
            $table->string('lab_no')->nullable();
            $table->unsignedBigInteger('requested_by');
            $table->date('date_requested');
            $table->unsignedBigInteger('collected_by');
            $table->dateTime('date_collected');
            $table->unsignedBigInteger('study_id');
            $table->string('sample_is_for')->nullable();
            $table->string('priority')->nullable();
            $table->text('tests_requested')->nullable();
            $table->integer('test_count')->default(0);
            $table->text('tests_performed')->nullable();
            $table->unsignedBigInteger('request_acknowledged_by')->nullable();
            $table->dateTime('date_acknowledged')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('creator_lab');
            $table->string('status')->default('Accessioned');
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
        Schema::dropIfExists('samples');
    }
};
