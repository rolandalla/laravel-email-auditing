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
        try {
            Schema::create('email_auditing', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('from');
                $table->string('to');
                $table->string('cc')->nullable();
                $table->string('bcc')->nullable();
                $table->string('replyTo')->nullable();
                $table->string('subject');
                $table->longText('body');
                $table->string('attachments')->nullable();
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users')->onCascade('delete');
            });
        } catch (\Exception $e) {
            return 'Table already exists';
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_auditing');
    }
};
