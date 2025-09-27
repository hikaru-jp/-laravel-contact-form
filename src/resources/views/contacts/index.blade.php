<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> お問い合わせフォーム</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/contacts.css') }}">
</head>

<body>
    <div class="contact-form__content">
        <div class="contact-form__heading">
            <h1 class="page-title">FashionablyLate</h1>
            <h2 class="page-subtitle">Contact</h2>
        </div>
        <form class="form" action="{{ route('contacts.confirm') }}" method="post">
            @csrf
            <!-- お名前 -->
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">お名前</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content form__name">
                    <div class="name-input">
                        <input type="text" name="last_name" placeholder="例: 山田" value="{{ old('last_name') }}">
                        @error('last_name')
                            <p class="form__error">姓を入力してください</p>
                        @enderror
                    </div>
                    <div class="name-input">
                        <input type="text" name="first_name" placeholder="例: 太郎" value="{{ old('first_name') }}">
                        @error('first_name')
                            <p class="form__error">名を入力してください</p>
                        @enderror
                    </div>
                </div>
            </div>
            <!-- 性別 -->
            <div class="form__group">
                <div class="form__group-title"> <span class="form__label--item">性別</span> <span
                        class="form__label--required">※</span> </div>
                <div class="form__group-content gender-group"> <label><input type="radio" name="gender"
                            value="male" {{ old('gender') == 'male' ? 'checked' : '' }}> 男性</label> <label><input
                            type="radio" name="gender" value="female"
                            {{ old('gender') == 'female' ? 'checked' : '' }}> 女性</label> <label><input type="radio"
                            name="gender" value="other" {{ old('gender') == 'other' ? 'checked' : '' }}> その他</label>
                    @error('gender')
                        <span class="form__error-inline">性別を選択してください</span>
                    @enderror
                </div>
            </div>


            <!-- メールアドレス -->
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">メールアドレス</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <!-- type="text" にする -->
                    <input type="text" name="email" placeholder="例: test@example.com" value="{{ old('email') }}">
                </div>
                @error('email')
                    <p class="form__error">
                        @if ($message === 'The email must be a valid email address.')
                            メールアドレスはメール形式で入力してください
                        @else
                            メールアドレスを入力してください
                        @endif
                    </p>
                @enderror
            </div>

            <!-- 電話番号 -->
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">電話番号</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content tel-group">
                    <input type="text" name="tel1" placeholder="080" value="{{ old('tel1') }}">
                    <span>-</span>
                    <input type="text" name="tel2" placeholder="1234" value="{{ old('tel2') }}">
                    <span>-</span>
                    <input type="text" name="tel3" placeholder="5678" value="{{ old('tel3') }}">

                    @if ($errors->has('tel1') || $errors->has('tel2') || $errors->has('tel3'))
                        <span class="form__error-inline">電話番号を入力してください</span>
                    @endif
                </div>
            </div>




            <!-- 住所 -->
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">住所</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <input type="text" name="address" placeholder="例: 東京都渋谷区千代田1-2-3" value="{{ old('address') }}">
                </div>
                @error('address')
                    <p class="form__error">住所を入力してください</p>
                @enderror
            </div>

            <!-- 建物名 -->
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">建物名</span>
                </div>
                <div class="form__group-content">
                    <input type="text" name="building" placeholder="例: 千代田マンション101" value="{{ old('building') }}">
                </div>
                @error('building')
                    <div class="form__error">{{ $message }}</div>
                @enderror
            </div>

            <!-- お問い合わせの種類 -->
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">お問い合わせの種類</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <select name="category_id">
                        <option value="">選択してください</option>
                        <option value="1" @selected(old('category_id') == 1)>商品について</option>
                        <option value="2" @selected(old('category_id') == 2)>サポート</option>
                        <option value="3" @selected(old('category_id') == 3)>その他</option>
                    </select>
                </div>
                @error('category_id')
                    <div class="form__error">お問い合わせの種類を選択してください</div>
                @enderror
            </div>


            <!-- お問い合わせ内容 -->
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">お問い合わせ内容</span>
                    <span class="form__label--required">※</span>
                </div>
                <div class="form__group-content">
                    <textarea name="content" placeholder="お問い合わせ内容をご記載ください">{{ old('content') }}</textarea>
                </div>
                @error('content')
                    <p class="form__error">
                        @if (str_contains($message, 'characters'))
                            お問い合わせ内容は120文字以内で入力してください
                        @else
                            お問い合わせ内容を入力してください
                        @endif
                    </p>
                @enderror
            </div>

            <!-- 確認ボタン -->
            <div class="form__group">
                <button type="submit" class="form__button">確認画面</button>
            </div>

        </form>
</body>

</html>
