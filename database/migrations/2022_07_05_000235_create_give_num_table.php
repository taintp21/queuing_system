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
        Schema::create('give_num', function (Blueprint $table) {
            $table->id();
            $table->string('order', 100);
            $table->string('name');
            $table->string("phone", 50);
            $table->string("email", 100);
            $table->unsignedBigInteger('services_id', false);
            $table->timestamp("expired_date")->nullable();
            $table->tinyInteger('status')->comment("0 = Đang chờ, 1 = Đã sử dụng, 2 = Bỏ qua");
            $table->string('supply',50);
            $table->timestamps();
            $table->foreign('services_id')->references('id')->on('services')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('give_num');
    }
};
