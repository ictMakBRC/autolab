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
        // Add preliminary_tests column to tests table
        Schema::table('tests', function (Blueprint $table) {
            $table->json('preliminary_tests')->nullable()->after('parameters')
                ->comment('Array of test IDs that are preliminary tests for this main test');
        });

        // Add columns to test_results table for preliminary test support
        Schema::table('test_results', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_test_id')->nullable()->after('test_id')
                ->comment('ID of the main test if this is a preliminary test result');
            $table->json('preliminary_test_ids')->nullable()->after('parameters')
                ->comment('Array of preliminary test result IDs linked to this main result');
            
            // Add foreign key for parent_test_id
            $table->foreign('parent_test_id')
                ->references('id')
                ->on('tests')
                ->onDelete('set null');
        });

        // Add result_file and status columns to sample_referrals table
        Schema::table('sample_referrals', function (Blueprint $table) {
            $table->string('result_file')->nullable()->after('reason')
                ->comment('Path to uploaded result file from referral facility');
            $table->date('received_date')->nullable()->after('result_file')
                ->comment('Date when results were received from referral facility');
   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->dropColumn('preliminary_tests');
        });

        Schema::table('test_results', function (Blueprint $table) {
            $table->dropForeign(['parent_test_id']);
            $table->dropColumn(['parent_test_id', 'preliminary_test_ids']);
        });

        Schema::table('sample_referrals', function (Blueprint $table) {
            $table->dropColumn(['result_file', 'received_date', 'status']);
        });
    }
};