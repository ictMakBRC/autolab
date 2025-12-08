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

        // Add result_file and status columns to sample_referrals table
        Schema::table('sample_referrals', function (Blueprint $table) {
            $table->string('result_file')->nullable()->after('reason')
                ->comment('Path to uploaded result file from referral facility');
            $table->date('received_date')->nullable()->after('result_file')
                ->comment('Date when results were received from referral facility');

        });

        // Add to your test_results table migration or create new migration
        Schema::table('test_results', function (Blueprint $table) {
            // QC Management Fields
            $table->boolean('qc_first_pass_accepted')->default(true)->after('status');
            $table->tinyInteger('qc_total_attempts')->default(1)->after('qc_first_pass_accepted');
            $table->integer('qc_final_attempt_time')->nullable()->comment('In minutes')->after('qc_total_attempts');
            $table->string('qc_failure_reason', 255)->nullable()->after('qc_final_attempt_time');
            $table->enum('qc_application_scope', ['batch', 'sample', 'run', 'instrument'])->default('sample')->after('qc_failure_reason');
            $table->string('result_supporting_document')->nullable()->after('status');
            $table->decimal('qc_efficiency_score', 5, 2)->nullable()->after('qc_application_scope');
            $table->enum('qc_compliance_status', ['compliant', 'acceptable', 'non_compliant'])->nullable()->after('qc_efficiency_score');

            // Batch-specific fields
            $table->string('batch_identifier', 100)->nullable()->after('qc_compliance_status');
            $table->integer('batch_size')->nullable()->after('batch_identifier');
            $table->integer('batch_qc_samples_count')->nullable()->after('batch_size');
            $table->unsignedBigInteger('parent_result_id')->nullable()->after('test_id');
            $table->enum('result_type', ['Main', 'Preliminary'])->default('Main')->after('test_id');
            $table->unsignedBigInteger('parent_test_id')->nullable()->after('test_id')
                ->comment('ID of the main test if this is a preliminary test result');
            $table->json('preliminary_test_ids')->nullable()->after('parameters')
                ->comment('Array of preliminary test result IDs linked to this main result');

            // Add foreign key for parent_test_id
            $table->foreign('parent_test_id')
                ->references('id')
                ->on('tests')
                ->onDelete('set null');
            // Indexes for reporting
            $table->index('qc_first_pass_accepted');
            $table->index('qc_application_scope');
            $table->index('batch_identifier');
            $table->index('qc_compliance_status');
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
