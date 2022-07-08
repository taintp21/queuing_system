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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string("service_code", 100);
            $table->string("service_name", 100);
            $table->text("description");
            $table->tinyInteger("status")->comment("0 = Hoạt động, 1 = Ngưng hoạt động");
            $table->string("number_from", 100)->comment("Tăng tự động từ");
            $table->string("number_to")->comment("Tăng tự động đến");
            $table->string("prefix", 100)->default(1);
            $table->string("surfix", 100)->default(1);
            $table->tinyInteger("reset")->nullable();
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
        Schema::dropIfExists('services');
    }
};
