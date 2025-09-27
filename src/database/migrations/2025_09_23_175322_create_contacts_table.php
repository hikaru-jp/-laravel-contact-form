<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            // 名前
            $table->string('last_name'); // 姓（必須）
            $table->string('first_name'); // 名（必須）

            // 性別
            $table->string('gender'); // 必須

            // メールアドレス
            $table->string('email'); // 必須

            // 電話番号（3分割）
            $table->string('tel1');
            $table->string('tel2');
            $table->string('tel3');

            // 住所
            $table->string('address'); // 必須
            $table->string('building')->nullable(); // 任意（建物名）

            // カテゴリ（外部キー）
            $table->unsignedBigInteger('category_id');
            $table
                ->foreign('category_id')
                ->references('id')
                ->on('categories') // categories.id を参照
                ->onDelete('cascade');

            // 問い合わせ内容
            $table->text('content'); // 必須

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
