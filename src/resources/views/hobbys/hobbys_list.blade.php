<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
{{-- <?php include('hobbys.sidebar_css'); ?> --}}
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

<title>My投稿一覧</title>
</head>
<body>
    <div class="test2">
        @include('hobbys.sidebar')
    </div>
    <div class="content_wrapper">
        <div class="hobby__regist">
            <a href=""><button>新規登録</button></a>
        </div>
        <div class="search__area">
            <table>
                <tr>
                    <td>
                        <select name="" id=""></select>
                    </td>
                    <td>
                        <select name="" id=""></select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <select name="" id=""></select>
                    </td>
                    <td>
                        <input type="text">
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

        <div class="hobby__list">
            <div class="hobby__item">
                <div class="user">
                    <div class="user__frame">
                        <img src="https://picsum.photos/200" alt="">
                    </div>
                </div>

                <div class="content">
                    <h3 class="content__title">プログラミングを勉強しよう！</h1>
                        <div class="content__item">
                            <div class="content__detail">
                                <p>ニックネーム</p>
                                <p>場所</p>
                                <p>投稿日時</p>
                                <p>参加したいね</p>
                                <!-- 自分がいいねしたもののみ表示する -->
                                <button class="contact__button">問い合わせ</button>
                            </div>
                            <div class="hobby__img">
                                <!-- ここの写真サイズをどうすれば良いか？ -->
                                <div class="hobby_img_frame">
                                    <img src="https://picsum.photos/1000/1000" alt="">
                                </div>

                            </div>
                            <!-- width 100% display flexwrapで折り返しにする -->
                            <div class="content__text">
                                <p>
                                この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字
                                </p>
                            </div>
                        </div>
                </div>
            </div>
            <div class="hobby__item">
                <div class="user">
                    <div class="user__frame">
                        <img src="https://picsum.photos/200" alt="">
                    </div>
                </div>

                <div class="content">
                    <h3 class="content__title">プログラミングを勉強しよう！</h1>
                        <div class="content__item">
                            <div class="content__detail">
                                <p>ニックネーム</p>
                                <p>場所</p>
                                <p>投稿日時</p>
                                <p>参加したいね</p>
                                <!-- 自分がいいねしたもののみ表示する -->
                                <button class="contact__button">問い合わせ</button>
                            </div>
                            <div class="hobby__img">
                                <!-- ここの写真サイズをどうすれば良いか？ -->
                                <div class="hobby_img_frame">
                                    <img src="https://picsum.photos/1000/1000" alt="">
                                </div>

                            </div>
                            <!-- width 100% display flexwrapで折り返しにする -->
                            <div class="content__text">
                                <p>
                                この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字
                                </p>
                            </div>
                        </div>
                </div>
            </div>
            <div class="hobby__item">
                <div class="user">
                    <div class="user__frame">
                        <img src="https://picsum.photos/200" alt="">
                    </div>
                </div>

                <div class="content">
                    <h3 class="content__title">プログラミングを勉強しよう！</h1>
                        <div class="content__item">
                            <div class="content__detail">
                                <p>ニックネーム</p>
                                <p>場所</p>
                                <p>投稿日時</p>
                                <p>参加したいね</p>
                                <!-- 自分がいいねしたもののみ表示する -->
                                <button class="contact__button">問い合わせ</button>
                            </div>
                            <div class="hobby__img">
                                <!-- ここの写真サイズをどうすれば良いか？ -->
                                <div class="hobby_img_frame">
                                    <img src="https://picsum.photos/1000/1000" alt="">
                                </div>

                            </div>
                            <!-- width 100% display flexwrapで折り返しにする -->
                            <div class="content__text">
                                <p>
                                この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字
                                </p>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>