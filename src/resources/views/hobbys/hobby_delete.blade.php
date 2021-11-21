<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
*{
box-sizing: border-box;
}

.regist{
    max-width: 720px;
}

.inputs{
    width: 100%;
}

.item{
    width: 100%;
    margin-bottom: 20px;
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


select{
    border: solid 1px #aaa;
    border-radius:5px;
    padding:10px;
    font-size: 16px;
    width: 25%;
}

select:focus {
    border: 1px solid #fcbe14;
    outline: 0;
}

#municipalities{
    display: flex;
    justify-content: space-between;
}

.municipalities{
    width: 70%;
}

textarea{
    border: solid 1px #aaa;
    border-radius:5px;
    padding: 10px;
    height: 160px;
    font-size: 16px;
}

textarea:focus {
    border: 1px solid #fcbe14;
    outline: 0;
}


.regist__content{
    display: flex;
}

.input__item{
    width: calc(100% - 100px);
}

.user{
    width: 100px;
    padding: 10px 15px;
    text-align: center;
}

.user img{
    border-radius: 50%;
    width: 100%;
}

.hobby__img .hobby_img_frame img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.hobby_img_frame{
        /* width: 100%;
        height: 50vw; */
        width: 400px;
        height: 250px;
        box-shadow: 5px 10px 20px rgba(0,0,0,0.25);
        border-radius: 15px;
        margin: 10px;
    }
.post__btn {
	display: inline-block;
    font-size: 16px;
	width: 30%;
	padding: 10px;
	text-align: center;
	text-decoration: none;
	color: #fff;
	background:#fcbe14;
	border-bottom:4px solid #1E48B1;
	border-radius: 10px;
	transition: .0s;
}
.post__btn:hover {
    cursor: pointer;
    text-decoration: none;
    background:#1E48B1;
    transform: translate3d(0, 4px, 0);
    transition: .0s;
    border-bottom: none;
}
.content_wrapper {
    disable:
}
</style>

<title>趣味削除画面</title>
</head>
<body>
    <div class="test2">
        @include('hobbys.sidebar')
    </div>
    <div class="content_wrapper">
        <form action="{{route('hobby_delete', ['id'=> $post['id']])}}" method="post" enctype="multipart/form-data" disabled>
            @csrf
            <div class="regist">
                <div class="regist__content">
                    <div class="user">
                        <img src="https://picsum.photos/100" alt="">
                    </div>
                    <div class="input__item">
                        <span>＊30文字以内</span>
                        <div class="item">
                            <input class="inputs" type="text" name="title" value="{{ $post['title'] }}" placeholder="タイトルを入力下さい" disabled>
                            @error('title')
                                {{$message}}
                            @enderror
                        </div>
                        <span>＊県名</span>
                        <div class="item" id="municipalities" value="">
                            {{$form['prefecture']}}
                            <input type="text" name="municipalities" class="municipalities" value="{{ $post['municipalities'] }}" placeholder="市区町村を入力下さい" disabled>
                        </div>
                        <span>＊趣味カテゴリー</span>
                        <div class="item">
                            {{$form['category']}}
                        </div>
                        <span>＊300文字以内</span>
                        <div class="item">
                            <textarea class="inputs" name="text" id="" cols="30" rows="10" value="" textarea placeholder="詳細を記入下さい" disabled>{{ $post['text'] }}</textarea>
                            @error('text')
                                {{$message}}
                            @enderror
                        </div>
                        <hr>
                        <span>＊趣味に関する写真</span>
                        <div class="hobby__img">
                            <div class="hobby_img_frame">
                                    @if (!empty($post['hobby_img_path']))
                                        <img src="../../uploads/post/{{ $post['hobby_img_path'] }}">
                                    @else
                                        <img src="../../uploads/post/no_image_logo.png">
                                    @endif
                            </div>
                        </div>
                        <div>
                            <button class="post__btn" type="submit">削除する</button>
                        </div>
                        <div>
                            <p><a href="{{ route('user_mypage') }}" class="">戻る</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>