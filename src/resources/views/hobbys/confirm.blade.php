<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問い合わせ確認画面</title>
    @include('hobbys.sidebar_css')
    <style>
        h1 {
        margin:0;
        padding:0;
        border:0;
        outline:0;
        font-size:100%;
        vertical-align:baseline;
        background:transparent;
        margin-bottom: 30px;
        font-size: 100%;
        color: #222;
        }
        .content_wrapper {
        transition: margin-left .3s ease-in-out;
        margin-left: 275px;
        }
        input[type="text"],
            textarea {
                margin-bottom: 20px;
                padding: 10px;
                font-size: 86%;
                border: 1px solid #ddd;
                border-radius: 3px;
                background: #fff;
        }

        input[type="text"] {
            width: 200px;
        }
        textarea {
            width: 50%;
            max-width: 50%;
            height: 70px;
        }
        input[type="submit"] {
            appearance: none;
            -webkit-appearance: none;
            padding: 10px 20px;
            color: #fff;
            font-size: 86%;
            line-height: 1.0em;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: #37a1e5;
        }
        input[type=submit]:hover,
        button:hover {
            background-color: #1E48B1;
        }
        button {
            -webkit-appearance: none;
            padding: 10px 20px;
            color: #fff;
            font-size: 86%;
            line-height: 1.0em;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: #1E48B1;
        }
    </style>
</head>
<body>
@include('hobbys.sidebar')
    <div class="content_wrapper">
    <h1>趣味への問い合わせ内容確認</h1>
    <form method="post" action="{{ route('complete') }}?id={{ $to_user['id'] }}" class="">
        @csrf
        <input type="hidden" name="to_user_id" value="{{$to_user['id']}}">
        <input type="hidden" name="to_nickname" value="{{$to_user['nickname']}}">
        <input type="hidden" name="to_mail" value="{{$to_user['mail']}}">
        <input type="hidden" name="user_id" value="{{$user->id}}">
        <input type="hidden" name="nickname" value="{{ $user->nickname }}">
        <input type="hidden" name="mail" value="{{$user->mail}}">
        <input type="hidden" name="title" value="{{ $inputs['title'] }}">
        <input type="hidden" name="body" value="{{ $inputs['body'] }}">
        <p>ニックネーム：{{ $user->nickname }}</p>
        <p>件名：{{ $inputs['title'] }}</p> <!-- {{ $contact['title'] }} -->
        <p>メールアドレス：{{ $user->mail }}</p> 
        <p>問い合わせ内容</p>
        {{ $inputs['body'] }} <!-- {{ $user->message }} -->
        <button class="inquiry" name="action" type="submit" value="submit">問い合わせる</button>
    </form>
    </div>
</body>
</html>