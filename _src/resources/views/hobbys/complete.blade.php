<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問い合わせ</title>
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
    @csrf
    <div class="content_wrapper">
    <h1>趣味への問い合わせ完了</h1>
    <a href="{{ route('hobby.list') }}" class="btn btn-primary">趣味一覧画面に戻る</a>
    </div>
</body>
</html>