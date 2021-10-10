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


    /* 検索エリア */
    .search__area{
        max-width: 1000px;
    }

    input{
        width: 300px;
    }

    select{
        width: 200px;
        margin: 10px;
    }

    input[type="text"]{
        border: solid 1px #aaa;
        border-radius:5px;
        padding:10px;
        font-size: 16px;
        margin: 10px;
    }

    input[type="text"]:focus {
        border: 1px solid #fcbe14;
        outline: 0;
    }


    select{
        border: solid 1px #aaa;
        border-radius:5px;
        padding:10px;
        font-size: 16px;
    }

    select:focus {
        border: 1px solid #fcbe14;
        outline: 0;
    }

    .search__btn{
        display: inline;
        margin: 8px;
    }

    .btn__search {
        display: inline-block;
        font-size: 16px;
        width: 40%;
        padding: 10px;
        text-align: center;
        text-decoration: none;
        color: #fff;
        background:#fcbe14;
        border-bottom:4px solid #1E48B1;
        border-radius: 10px;
        transition: .0s;
    }
    .btn__search:hover {
        cursor: pointer;
        text-decoration: none;
        background:#1E48B1;
        transform: translate3d(0, 4px, 0);
        transition: .0s;
        border-bottom: none;
    }

    .btn__clear {
        display: inline-block;
        font-size: 16px;
        width: 40%;
        padding: 10px;
        text-align: center;
        text-decoration: none;
        color: #fff;
        background:#fcbe14;
        border-bottom:4px solid #1E48B1;
        border-radius: 10px;
        transition: .0s;
    }
    .btn__clear:hover {
        cursor: pointer;
        text-decoration: none;
        background:#1E48B1;
        transform: translate3d(0, 4px, 0);
        transition: .0s;
        border-bottom: none;
    }
</style>
</head>
<body>
    <div class="test2">
        @include('hobbys.sidebar')
    </div>
    <div class="content_wrapper">
    <h1>趣味への問い合わせ</h1>
    <form method="post" action="{{ route('confirm', ['id'=> $user->id]) }}" class="">
        @csrf
        <p>件名</p>
        <input type="text" name="title" class="" minlength="10" maxlength="50" required>
        <p>ニックネーム：{{ $user->nickname }}</p>
        <p>メールアドレス：{{ $user->mail }}</p>
        <p>問い合わせ内容</p>
        <textarea id="message" name="message" minlength="10" maxlength="300" required></textarea>
        <div class="contact_btn">
            <button class="inquiry" type="submit">問い合わせる</button>
        </div>
    </form>
    </div>
</body>
</html>