<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'min_salary')) {
                $table->float('min_salary')->nullable()->change();
            }

            if (Schema::hasColumn('posts', 'max_salary')) {
                $table->float('max_salary')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Giả sử trước đây các cột này là kiểu integer, bạn có thể rollback về kiểu integer
            if (Schema::hasColumn('posts', 'min_salary')) {
                $table->integer('min_salary')->change();
            }

            if (Schema::hasColumn('posts', 'max_salary')) {
                $table->integer('max_salary')->change();
            }
        });
    }
};
