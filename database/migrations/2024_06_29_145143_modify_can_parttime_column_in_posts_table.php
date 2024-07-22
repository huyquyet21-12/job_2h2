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
            // Kiểm tra xem cột 'can_parttime' có tồn tại không
            if (Schema::hasColumn('posts', 'can_parttime')) {
                // Thay đổi kiểu dữ liệu của cột 'can_parttime' thành tinyint (boolean), cho phép null và default = 0
                $table->boolean('can_parttime')->nullable()->default(0)->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Để rollback, thay đổi lại kiểu dữ liệu của cột 'can_parttime' thành int và cho phép null
            $table->integer('can_parttime')->nullable()->change();
        });
    }
};
