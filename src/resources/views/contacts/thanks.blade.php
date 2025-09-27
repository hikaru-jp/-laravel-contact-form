<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>thank you</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/thanks.css') }}" />
</head>

<body>
  <div class="thanks-container">
        <p class="thanks-message">お問い合わせありがとうございました</p>
        <a href="{{ route('contacts.index') }}" class="btn-home">HOME</a>
    </div>
</body>
</html>