<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sample_receptions', function (Blueprint $table) {
            // $table->boolean('is_paternity')->default(0)->after('samples_delivered');
        });
    }

};
