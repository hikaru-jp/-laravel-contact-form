<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面 - お問い合わせ一覧</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>
    <div class="admin-header">
        <h1 class="site-title">FashionablyLate</h1>

        <div class="header-sub">
            <h2 class="page-title">Admin</h2>
        </div>

        <div class="header-right">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">logout</button>
            </form>
        </div>
    </div>

    <div class="admin-container">


        {{-- 検索フォーム --}}
        <form method="GET" action="{{ route('admin.contacts.index') }}" class="search-form">
            <!-- 名前 -->
            <input type="text" name="name" placeholder="名前で検索" value="{{ request('name') }}">

            <!-- メールアドレス -->
            <input type="text" name="email" placeholder="メールアドレスで検索" value="{{ request('email') }}">

            <!-- 性別 -->
            <select name="gender">
                <option value="">性別</option>
                <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>男性</option>
                <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>女性</option>
                <option value="other" {{ request('gender') === 'other' ? 'selected' : '' }}>その他</option>
            </select>

            <!-- お問い合わせ種類 -->
            <select name="category_id">
                <option value="">種類</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <!-- 日付 -->
            <input type="date" name="date" value="{{ request('date') }}">

            <button type="submit">検索</button>
            <a href="{{ route('admin.contacts.index') }}" class="btn-reset">リセット</a>

            <!-- エクスポート -->
            <a href="{{ route('admin.contacts.export', request()->all()) }}" class="btn-export">エクスポート</a>
        </form>

        {{--  お問い合わせ一覧 --}}
        <table class="contacts-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>お名前</th>
                    <th>性別</th>
                    <th>メールアドレス</th>
                    <th>お問い合わせ種類</th>
                    <th>登録日</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                    <tr>
                        <td>{{ $contact->id }}</td>
                        <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>
                        <td>
                            @if ($contact->gender === 'male')
                                男性
                            @elseif($contact->gender === 'female')
                                女性
                            @else
                                その他
                            @endif
                        </td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ optional($contact->category)->name }}</td>
                        <td>{{ $contact->created_at->format('Y-m-d') }}</td>
                        <td>
                            <button class="btn-detail" data-url="{{ route('admin.contacts.show', $contact->id) }}">
                                詳細
                            </button>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{--  ページネーション --}}
        <div class="pagination">
            {{ $contacts->links('pagination::bootstrap-4') }}
        </div>
    </div>

    {{-- モーダル（詳細表示用） --}}
    <div id="modal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modal-body"></div>
        </div>
    </div>

    {{-- JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('modal');
            const modalBody = document.getElementById('modal-body');
            const closeBtn = document.querySelector('.close');

            // 詳細ボタン処理
            document.querySelectorAll('.btn-detail').forEach(button => {
                button.addEventListener('click', async () => {
                    const url = button.getAttribute('data-url');

                    try {
                        const response = await fetch(url);
                        const data = await response.json();

                        const date = new Date(data.created_at);
                        const formattedDate = date.toLocaleDateString('ja-JP');

                        modalBody.innerHTML = `
                            <h2>詳細情報</h2>
                            <p><strong>ID:</strong> ${data.id}</p>
                            <p><strong>名前:</strong> ${data.last_name} ${data.first_name}</p>
                            <p><strong>性別:</strong> ${data.gender}</p>
                            <p><strong>メール:</strong> ${data.email}</p>
                            <p><strong>電話:</strong> ${data.tel1}-${data.tel2}-${data.tel3}</p>
                            <p><strong>住所:</strong> ${data.address} ${data.building ?? ''}</p>
                            <p><strong>種類:</strong> ${data.category?.name ?? ''}</p>
                            <p><strong>内容:</strong> ${data.content}</p>
                            <p><strong>登録日:</strong> ${formattedDate}</p>
                             <button id="deleteBtn">削除</button>
                        `;

                        // 削除ボタンの動作を定義
                        document.getElementById('deleteBtn').addEventListener('click',
                            async () => {
                                if (confirm('本当に削除しますか？')) {
                                    const response = await fetch(
                                        `/admin/contacts/${data.id}`, {
                                            method: 'DELETE',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            }
                                        });

                                    if (response.ok) {
                                        alert('削除しました');
                                        modal.style.display = 'none';
                                        location.reload();
                                    } else {
                                        alert('削除に失敗しました');
                                    }
                                }
                            });

                        modal.style.display = 'block';
                    } catch (error) {
                        alert('詳細の取得に失敗しました');
                    }
                });
            });

            // 閉じる処理
            closeBtn.addEventListener('click', () => {
                modal.style.display = 'none';
            });
            window.addEventListener('click', e => {
                if (e.target === modal) modal.style.display = 'none';
            });
        });
    </script>
</body>

</html>
