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
        Schema::table('users', function (Blueprint $table) {
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
    }
};
