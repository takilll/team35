<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('sidebar_css.php')
    <style>
    .content_wrapper {
        transition: margin-left .3s ease-in-out;
        margin-left: 250px;
    }
    h1 {
        background: #fcbe14;
        border-bottom: 15px solid #eef;
        font-size: 50px;
        line-height: 50px;
        margin-bottom: 0;
    }
    h3 {
        margin-left: 30px;
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
    .my_edit .edit {
        padding: 10px 20px;
        color: #fff;
        font-size: 86%;
        line-height: 1.0em;
        cursor: pointer;
        border: none;
        border-radius: 5px;
        background-color: #1E48B1;
    }
    .my_edit .delete {
        padding: 10px 20px;
        color: #fff;
        font-size: 86%;
        line-height: 1.0em;
        cursor: pointer;
        border: none;
        border-radius: 5px;
        background-color: #1E48B1;
    }
    .edit_button {
        margin-left: 30px;
    }
    
    .test2 {
        position: fixed; 
    }
</style>
    <title>My投稿一覧</title>
</head>
<body>
    <div class="test2">
    @include('sidebar.blade.php')
    </div>
    <div class="content_wrapper">
        <h1>MY投稿一覧</h1>
        @foreach( $posts as $value )
            <div class="main_content">
                <div class="my-icon">
                    <img src="{{ $value['profile_img_path'] }}" alt="">
                </div>
                <div class="hobby_content">
                    <h3 class="title">{{ $value['title'] }}</h3>
                    <div class="sub_content">
                        <div class="sub_sub_content">
                            <div class="hobby_text">
                                <p class="nickname">{{ $value['nickname'] }}</p>
                                <p class="prefecture municipalities">{{ $value['prefecture'] }}{{ $value['municipalities'] }}</p>
                                <p class="time">{{ $value['updated_at'] }}</p>
                            </div>
                            <div class="like_hobby">
                                <div class="">参加したいね！</div>
                                <div class="like">
                                    <img src="\team35\src\resources\views\img\icon-heart-twitterblue.svg" alt="">
                                </div>
                                <div class="like-count">101462475</div> 
                            </div>
                        </div>
                        <div class="hobby_picture">
                            <img src="{{ $value['hobby_img_path'] }}" alt="">
                        </div>
                    </div>
                    <div class="edit_button">
                        <form action="post" class="my_edit">
                            <button class="edit" type="submit">編集する</button>
                            <button class="delete" type="submit">削除する</button>
                        </form>
                        <div class="mypage_text">
                            {{ $value['text'] }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>