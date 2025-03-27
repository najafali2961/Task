<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketLabelTable extends Migration
{
    public function up()
    {
        Schema::create('ticket_label', function (Blueprint $table) {
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('label_id');
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
            $table->foreign('label_id')->references('id')->on('labels')->onDelete('cascade');
            $table->primary(['ticket_id', 'label_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_label');
    }
}
