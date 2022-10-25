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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('participant_no')->unique();
            $table->string('identity')->unique();
            $table->integer('age');
            $table->string('gender', 6);
            $table->string('address', 40);
            $table->string('contact', 20);
            $table->string('nok_contact', 20);
            $table->string('nok_address', 40);
            $table->text('clinical_notes')->nullable();

            $table->string('title')->nullable();
            $table->string('nin_number')->nullable();
            $table->string('surname')->nullable();
            $table->string('first_name')->nullable();
            $table->string('other_name')->nullable();
            $table->string('nationality')->nullable();
            $table->string('district')->nullable();
            $table->date('dob')->nullable();
            $table->string('email')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('religious_affiliation')->nullable();
            $table->string('occupation')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('nok')->nullable();
            $table->string('nok_relationship')->nullable();
            $table->unsignedBigInteger('facility_id')->nullable();
            $table->unsignedBigInteger('study_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('creator_lab');
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
        Schema::dropIfExists('participants');
    }
};
