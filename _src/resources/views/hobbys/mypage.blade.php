<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        padding: 20px; /*瀧川修正*/
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
    
    h1 {
        background: #fcbe14;
        border-bottom: 15px solid #eef;
        font-size: 50px;
        line-height: 50px;
        margin-bottom: 0;
    }
    .main_content {
        display: flex;
        margin-top: 20px;
        margin-right: 50px;
        border-bottom: 1px solid #eef;
    }
    .my-icon img {
        text-align: left;
        width: calc(100% - 90px);
        border-left: 1px solid #eef;
        border-right: 1px solid #eef;
        max-width: 100px;
        width: 100%;
        max-height: 100px;
        height: 100%;
        border-radius: 50%;
        border: 0.2px solid #fcbe14;
        margin-right: 30px;
        margin-left: 30px;
    }
    .hobby_content {
        margin: 0;
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
    }
    .hobby_content .lile_hobby {
        display: inline-block;
        display: flex;
    }
    .like img {
        width: calc(100% - 90px);
        border-left: 1px solid #fff;
        border-right: 1px solid #fff;
        text-align: left;
        max-width: 50px;
        width: 25px;
        margin-right: 10px;
        cursor: pointer;
    }
    .like_hobby {
        display: flex;
    }
    .sub_sub_content {
        width: 300px;
        margin-left: 30px;
    }
    .hobby_text {
        width: calc(100% - 90px);
        max-width: 600px;
        text-align: left;
        display: block;
        margin-top: 0em;
        margin: 0;
        font-family: var(--bs-font-sans-serif);
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        -webkit-text-size-adjust: 100%;
        -webkit-tap-highlight-color: transparent;
    }
    .hobby_picture {
        width: calc(100% - 90%);
        max-width: 300px;
        max-height: 300Px;
        border-left: 1px solid #eef;
        border-right: 1px solid #eef;
        display: inline-block;
    }

    .hobby_picture img {
        width: 250px;
    }
    .sub_content {
    display: flex;
    }
    .edit_button {
        display: flex;
    }
    .edit {
        padding: 10px 20px;
        color: #fff;
        font-size: 86%;
        line-height: 1.0em;
        cursor: pointer;
        border: none;
        border-radius: 5px;
        background-color: #1E48B1;
        margin-right: 10px;
    }
    .delete {
        padding: 10px 20px;
        color: #fff;
        font-size: 86%;
        line-height: 1.0em;
        cursor: pointer;
        border: none;
        border-radius: 5px;
        background-color: #1E48B1;
        margin-right: 5Spx;
    }
    
    .test2 {
        position: fixed; 
    }
    .heart{
        width: 15%
    }
</style>
    <title>My投稿一覧</title>
</head>
<body>
    <div class="test2">
    @include('hobbys.sidebar')
    </div>
    <div class="content_wrapper">
        <h1>MY投稿一覧</h1>
        <div class="hobby__list">
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
                                    <p>参加したいね数：{{$hobby->likes_count}}</p>
                                    <div class="edit_button">
                                        <p><a href="{{ route('hobby_edit') }}?id={{ $hobby->id }}" class="" name="hobby_edit"><button class="edit">編集する</button></a>
                                        <p><a href="{{ route('hobby_delete') }}?id={{ $hobby->id }}" class="" name="hobby_delete"><button class="delete">削除する</button></a>
                                    </div>
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
</body>
</html>