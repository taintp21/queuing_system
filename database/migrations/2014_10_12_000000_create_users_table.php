<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("username")->unique();
            $table->string('name')->nullable();
            $table->string("avatar")->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string("phone", 50)->nullable();
            $table->string('password');
            $table->unsignedBigInteger("roles_id", false);
            $table->tinyInteger("status")->default(1)->comment("0 = Active, 1 = Inactive");
            $table->rememberToken();
            $table->timestamps();
            $table->foreign("roles_id")->references("id")->on("roles")->onDelete("cascade")->onUpdate("cascade");
        });
    }
    protected function dropColumn($table, $column) {
        try {
            Schema::disableForeignKeyConstraints();
            Schema::table($table, function (Blueprint $tbl) use ($column) {
                $tbl->dropColumn($column);
            });
        } catch (Illuminate\Database\QueryException $e)
        {
            Schema::table($table, function (Blueprint $tbl) use ($column) {
                $tbl->dropConstrainedForeignId($column);
            });
        } finally {
            Schema::enableForeignKeyConstraints();
        }
    }

    public function down()
    {
        $this->dropColumn('users', 'roles_id');
        Schema::dropIfExists("users");
    }
};
