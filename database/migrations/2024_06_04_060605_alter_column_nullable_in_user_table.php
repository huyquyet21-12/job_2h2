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
        //chinh lai tham so va gia tri cua bang users
        //phai them 1 cau lenh moi chu khong duoc sua
        Schema::table('users', function (Blueprint $table) {
            if(Schema::hasColumn('users','password')){
                $table->string('password')->nullable()->change();
            }
            if(Schema::hasColumn('users','city')){
                $table->string('city')->nullable()->change();
            }
            if(Schema::hasColumn('users','company_id')){
                $table->unsignedBigInteger('company_id')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
