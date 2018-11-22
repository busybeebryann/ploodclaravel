<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fc_report_bills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fc_hearing_id')->unsigned();
            $table->string('title');
            $table->string('short_title');
            $table->string('bill_number');
            $table->text('issue_support');
            $table->text('issue_against');
            $table->text('recommendations');
            $table->text('action_taken');
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
        Schema::dropIfExists('fc_report_bills');
    }
}
