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
        Schema::table('comments', function (Blueprint $table) {
            // 外部キー制約を削除する前に、外部キー制約をドロップします
            $table->dropForeign(['task_id']);
            // task_idカラムを削除
            $table->dropColumn('task_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            // カラムを再作成
            $table->foreignId('task_id')->constrained('tasks');
        });
    }
};
