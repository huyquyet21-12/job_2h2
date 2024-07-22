<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Kiểm tra xem cột 'remotable' có tồn tại không
            if (Schema::hasColumn('posts', 'remotable')) {
                // Thay đổi kiểu dữ liệu của cột 'remotable' thành int và cho phép null
                $table->integer('remotable')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Để rollback, thay đổi lại kiểu dữ liệu của cột 'remotable' thành varchar và cho phép null
            $table->string('remotable')->nullable()->change();
        });
    }
};
