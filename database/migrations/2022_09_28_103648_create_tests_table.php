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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->references('id')->on('test_categories')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
			$table->integer('parent_id')->nullable();
			$table->string('name')->nullable();
			$table->string('short_code')->nullable()->unique();
			$table->string('code')->nullable()->unique();
			$table->string('unit')->nullable();
			$table->text('reference_range_min')->nullable();
			$table->text('reference_range_max')->nullable();
			$table->double('price',8,2)->default(0);
			$table->boolean('status')->default(1);
			$table->text('precautions')->nullable();
			$table->text('extra_details')->nullable();
            $table->timestamps();
            $table->foreignId('created_by')->references('id')->on('users')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tests');
    }
};
