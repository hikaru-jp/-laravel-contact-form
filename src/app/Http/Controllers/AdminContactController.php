<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminContactController extends Controller
{
    public function __construct()
    {
        // 管理画面 ログイン必須
        $this->middleware('auth');
    }

    /**
     * お問い合わせ一覧（検索 + ページネーション）
     */
    public function index(Request $request)
    {
        $query = Contact::with('category'); // 🔹 Category をJOIN

        // 名前検索（姓・名・フルネーム対応）
        if ($request->filled('name')) {
            $name = $request->input('name');
            $query->where(function ($q) use ($name) {
                $q->where('last_name', 'like', "%{$name}%")
                    ->orWhere('first_name', 'like', "%{$name}%")
                    ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$name}%"]);
            });
        }

        // メールアドレス検索
        if ($request->filled('email')) {
            $query->where('email', 'like', "%{$request->email}%");
        }

        // 性別検索
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // お問い合わせ種類検索（category_id）
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 日付検索
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // ページネーション（7件ごと）
        $contacts = $query->orderBy('created_at', 'desc')->paginate(7);

        // カテゴリー一覧を検索フォームに渡す
        $categories = Category::all();

        return view('admin.contacts.index', compact('contacts', 'categories'));
    }

    /**
     * 詳細データを返す（モーダル用）
     */
    public function show($id)
    {
        $contact = Contact::with('category')->findOrFail($id);

        return response()->json($contact);
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return response()->json(['message' => '削除しました'], 200);
    }
    /**
     * CSVエクスポート
     */
    public function export(Request $request): StreamedResponse
    {
        $query = Contact::with('category');

        // 検索条件　反映
        if ($request->filled('name')) {
            $name = $request->input('name');
            $query->where(function ($q) use ($name) {
                $q->where('last_name', 'like', "%{$name}%")
                    ->orWhere('first_name', 'like', "%{$name}%")
                    ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$name}%"]);
            });
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', "%{$request->email}%");
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $contacts = $query->get();

        $fileName = 'contacts_export_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        $callback = function () use ($contacts) {
            $handle = fopen('php://output', 'w');

            // ヘッダー行
            fputcsv($handle, ['ID', '姓', '名', '性別', 'メールアドレス', '電話番号', '住所', '建物名', '種類', '内容', '登録日']);

            // データ行
            foreach ($contacts as $contact) {
                fputcsv($handle, [
                    $contact->id,
                    $contact->last_name,
                    $contact->first_name,
                    $contact->gender,
                    $contact->email,
                    "{$contact->tel1}-{$contact->tel2}-{$contact->tel3}",
                    $contact->address,
                    $contact->building,
                    optional($contact->category)->name, // 🔹 categories.name を出力
                    $contact->content,
                    $contact->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
