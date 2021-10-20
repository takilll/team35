<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
{{-- <link rel="stylesheet" href="/css/sidebar_css.css"> --}}
@include('hobbys.sidebar_css')
<style>
    
    /* これも無いとだめ */
    .content_wrapper {
        transition: margin-left .3s ease-in-out;
        margin-left: 250px;
        padding: 30px; /*瀧川追加*/
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

    /*瀧川追加*/
    .btn_clear {
        background: none;
        border: none;
        outline: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        color: #fff;
    }
    /*瀧川追加*/
    .btn_new {
        max-width: 100px;
        display: inline-block;
        font-size: 16px;
        width: 40%;
        padding: 10px;
        text-align: center;
        text-decoration: none;
        color: #fff;
        background:#fcbe14;
        border: 0.5px solid #333;
        border-bottom:4px solid #1E48B1;
        border-radius: 10px;
        transition: .0s;
        margin: 13px 0px 13px 11px;
    }
    /*瀧川追加*/
    .btn_new:hover {
        cursor: pointer;
        text-decoration: none;
        background:#1E48B1;
        transform: translate3d(0, 4px, 0);
        transition: .0s;
        border-bottom: none;
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
        margin: 13px 0px 13px 0px; /*瀧川追加*/
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
        margin: 13px 0px 13px 0px; /*瀧川追加*/
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

<title>My投稿一覧</title>
</head>
<body>
    <div class="test2">
        @include('hobbys.sidebar')
    </div>

    <div class="content_wrapper">
        <div class="btn_new">
            <a href="{{route('hobby.regist')}}"><button class="btn_clear">新規登録</button></a>
        </div>
        <form method="post" name="frmSearch" action="">
            @csrf      
            <div class="search__area">
                <table>
                    <tr>
                        <td>
                            {{$form['category']}}
                        </td>
                        <td>
                            {{-- <select name="" id=""></select> --}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{$form['prefecture']}}
                        </td>
                        <td>
                            {{$form['municipalities']}}
                        </td>
                    </tr>
                    <tr>
                        <td class="search__btn">
                            <button name="btnSearch" type="submit" class="btn__search">検 索</button>
                        </td>
                        <td class="search__btn">
                            <button name="btnClearSearch" type="submit" class="btn__clear">クリア</button>
                        </td>
                    </tr>
                </table>
            </div>
        </form>

        <div class="hobby__list">
            {{$mes}}
            @foreach ($hobbys as $hobby)
                <div class="hobby__item">
                    <div class="user">
                        <div class="user__frame">
                            @if (!empty($hobby->profile_img_path))
                                <img src="../../uploads/profile/{{ $hobby->profile_img_path}}">
                            @else
                                <img src="../../uploads/profile/icon-profile.svg">
                            @endif
                        </div>
                    </div>
                    <div class="content">
                        <h3 class="content__title">{{$hobby->title}}</h1>
                            <div class="content__item">
                                <div class="content__detail">
                                    <p>{{$hobby->nickname}}</p>
                                    <p>場所 {{$def['prefecture'][$hobby->prefecture]?? __('')}}{{$hobby->municipalities}}</p>
                                    <p>投稿日時 {{$hobby->created_at}}</p>
                                    {{-- todoいいね機能 --}}
                                        {{-- いいねがある状態削除 --}}
                                        <p><a href="{{route('post.unlike',$hobby->id)}}"><img src="../../img/icon-heart-twitterblue.svg" alt=""></a></p>
                                        {{-- いいねが無い状態登録 --}}
                                        <p><a href="{{route('post.like',$hobby->id)}}"><img src="../../img/icon-heart.svg"alt=""></a></p>
                                    {{-- @endif --}}
                                    <!-- 自分がいいねしたもののみ表示する -->
                                    <a href="{{route('contact')}}?id={{ $hobby->user_id }}"><button class="contact__button">問い合わせ</button></a>
                                </div>
                                <div class="hobby__img">
                                    <div class="hobby_img_frame">
                                        @if (!empty($hobby->hobby_img_path))
                                            <img src="../../uploads/post/{{ $hobby->hobby_img_path }}">
                                        @else
                                            <img src="../../uploads/post/no_image_logo.png">
                                        @endif
                                    </div>
                                </div>
                                <!-- width 100% display flexwrapで折り返しにする -->
                                <div class="content__text">
                                    <p>{{$hobby->text}}</p>
                                </div>
                            </div>
                    </div>
                </div>    
            @endforeach
        </div>
    </div>
</body>
</html>

