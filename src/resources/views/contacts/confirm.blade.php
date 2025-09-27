<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
</head>

<body>
    <div class="contact-form__content">
        <div class="contact-form__heading">
            <h1 class="page-title">FashionablyLate</h1>
            <h2 class="page-subtitle">Confirm</h2>
        </div>
        <form class="form" action="{{ route('contacts.store') }}" method="post">
            @csrf
            <table class="confirm-table">
                <tr>
                    <th>お名前</th>
                    <td>{{ $contact['last_name'] }} {{ $contact['first_name'] }}</td>
                </tr>
                <tr>
                    <th>性別</th>
                    <td>
                        @if ($contact['gender'] === 'male')
                            男性
                        @elseif ($contact['gender'] === 'female')
                            女性
                        @else
                            その他
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td>{{ $contact['email'] }}</td>
                </tr>
                <tr>
                    <th>電話番号</th>
                    <td>{{ $contact['tel1'] }}-{{ $contact['tel2'] }}-{{ $contact['tel3'] }}</td>
                </tr>
                <tr>
                    <th>住所</th>
                    <td>{{ $contact['address'] }}</td>
                </tr>
                <tr>
                    <th>建物名</th>
                    <td>{{ $contact['building'] }}</td>
                </tr>
                <tr>
                    <th>お問い合わせの種類</th>
                    <td>
                        @if ($contact['category_id'] == 1)
                            商品について
                        @elseif ($contact['category_id'] == 2)
                            サポート
                        @elseif ($contact['category_id'] == 3)
                            その他
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>お問い合わせ内容</th>
                    <td>{!! nl2br(e($contact['content'])) !!}</td>
                </tr>
            </table>

            {{-- hiddenでデータ保持 --}}
            @foreach ($contact as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <div class="form__button">
                <button type="submit">送信</button>
                <button type="button" class="btn btn-cancel" onclick="history.back()">修正</button>
            </div>
        </form>
    </div>
</body>

</html>
