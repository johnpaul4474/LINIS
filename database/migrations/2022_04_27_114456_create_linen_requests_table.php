<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinenRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linen_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('office_id');
            $table->integer('ward_id');
            $table->integer('employee_id');
            $table->integer('product_id');
            $table->integer('status_id');
            $table->string('status');
            $table->integer('quantity');
            $table->integer('raw_material_id');
            $table->integer('product_id');
            $table->integer('product_bulk_id');
            $table->string('product_name');

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
        Schema::dropIfExists('linen_requests');
    }
}
