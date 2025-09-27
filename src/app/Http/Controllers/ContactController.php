<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('contacts.index');
    }
    public function confirm(Request $request)
    {
        //  バリデーション 追加
        $request->validate([
            'last_name' => 'required|string|max:50',
            'first_name' => 'required|string|max:50',
            'gender' => 'required',
            'email' => 'required|email',
            'tel1' => 'required|numeric|digits_between:2,5',
            'tel2' => 'required|numeric|digits_between:1,4',
            'tel3' => 'required|numeric|digits_between:4,5',
            'address' => 'required|string|max:100',
            'building' => 'nullable|string|max:100', // ← 任意
            'category_id' => 'required',
            'content' => 'required|string|max:500',
        ]);

        // 入力値 セッションに保存
        $request->flash();

        // 確認画面 データを渡す
        $contact = $request->only(['last_name', 'first_name', 'gender', 'email', 'tel1', 'tel2', 'tel3', 'address', 'building', 'category_id', 'content']);

        return view('contacts.confirm', compact('contact'));
    }

    public function store(Request $request)
    {
        $contact = $request->only(['last_name', 'first_name', 'gender', 'email', 'tel1', 'tel2', 'tel3', 'address', 'building', 'category_id', 'content']);

        Contact::create($contact);

        return redirect()->route('contacts.thanks');
    }

    // サンクス画面
    public function thanks()
    {
        return view('contacts.thanks');
    }
}
