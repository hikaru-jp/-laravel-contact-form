<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 入力画面
Route::get('/', [ContactController::class, 'index'])->name('contacts.index');

// 確認画面
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contacts.confirm');

// 保存処理
Route::post('/store', [ContactController::class, 'store'])->name('contacts.store');

// サンクス画面
Route::get('/thanks', [ContactController::class, 'thanks'])->name('contacts.thanks');

// ========================
// 管理画側（認証必須）
// ========================
Route::middleware(['auth'])->group(function () {
    // 一覧
    Route::get('/admin', [AdminContactController::class, 'index'])->name('admin.contacts.index');

    // 詳細取得（モーダル用）
    Route::get('/admin/contacts/{id}', [AdminContactController::class, 'show'])->name('admin.contacts.show');

    // CSVエクスポート
    Route::get('/admin/export', [AdminContactController::class, 'export'])->name('admin.contacts.export');

    // 削除処理
    Route::delete('/admin/contacts/{id}', [AdminContactController::class, 'destroy'])->name('admin.contacts.destroy');
});

