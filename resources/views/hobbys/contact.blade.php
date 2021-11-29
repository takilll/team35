<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問い合わせ</title>
    <link rel="stylesheet" href="/css/sidebar_css.css">
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
            padding: 40px;
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
            border: solid 1px #aaa;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
        }
        textarea {
            border: solid 1px #aaa;
            border-radius: 5px;
            padding: 10px;
            height: 160px;
            font-size: 16px;
        }
        textarea:focus {
            border: 1px solid #fcbe14;
            outline: 0;
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
    
    /* これも無いとだめ */
    .content_wrapper {
        transition: margin-left .3s ease-in-out;
        margin-left: 250px;
    }
    /* これが絶対必要スクロールがついてこない */
    .test2 {
            position: fixed; 
        }

    /* 木元作成CSS */
    img{
        width: 100%;
        height: 100%;
        object-fit: cover;
    }


    .hobby__list{
        padding: 10px;
    }

    .hobby__item{
        display: flex;
        justify-content: space-between;
        max-width: 1000px;
        padding: 10px;
        border-bottom: 1px solid #eef;
    }

    .user__frame{
        width: 100%;
        height: 80px;
    }

    .user{
        /* width: 80px; */
        text-align: center;
    }

    .user img{
        border-radius: 50%;
        width: 100%;
        /* width: 80px;
        height: 80px; */
    }

    .content{
        width: calc(100% - 80px);
        /* width: 90%; */
        padding: 10px;
    }

    .content__item{
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        width: 100%;
    }

    .content__detail{
        width: 25%;
    }

    .hobby__img{
        width: 70%;
    }

    .hobby_img_frame{
        /* width: 100%;
        height: 50vw; */
        width: 400px;
        height: 250px;
        box-shadow: 5px 10px 20px rgba(0,0,0,0.25);
        border-radius: 15px;
    }

    .hobby__img img{
        border-radius: 15px;
    }

    .content__text{
        margin-top:10px;
        width: 100%;
    }

    input[type="text"]{
        border: solid 1px #aaa;
        border-radius:5px;
        padding:10px;
        font-size: 16px;
    }

    input[type="text"]:focus {
        border: 1px solid #fcbe14;
        outline: 0;
    }
    .inputs{
        width: 800px;
    }
    span {
        color: red;
    }
</style>
</head>
<body>
    <div class="test2">
        @include('hobbys.sidebar')
    </div>
    <div class="content_wrapper">
    <h1>趣味への問い合わせ</h1>
    <form method="post" action="{{ route('confirm') }}?id={{ $to_user['id'] }}" class="">
        @csrf
        <span>＊50文字以内</span>
        <div class="item">
            <input type="hidden" name="id" value="{{$to_user['id']}}">
            <input type="hidden" name="nickname" value="{{$to_user['nickname']}}">
            <input type="hidden" name="mail" value="{{$to_user['mail']}}">
            <input type="text" name="title" class="" minlength="10" maxlength="50" placeholder="タイトルを入力下さい" required>
        </div>    
        <p>ニックネーム：{{ $user->nickname }}</p>
        <p>メールアドレス：{{ $user->mail }}</p>
        <span>＊300文字以内</span>
        <div class="content">
            <textarea class="inputs" id="body" name="body" minlength="10" maxlength="300" placeholder="問い合わせ内容を入力下さい" required></textarea>
        </div> 
        <div class="contact_btn">
            <button class="inquiry" type="submit">問い合わせる</button>
        </div>
    </form>
    </div>
</body>
</html>