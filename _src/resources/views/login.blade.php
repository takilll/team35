<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- link rel="icon" href="../views/img"-->
    <!--link rel="stylesheet" href="../views/css/style.css"-->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>ログイン画面/hobbys</title>
    <meta name="description" content="ログイン画面です">

    <style type="text/css">
    body.signup {
        display: flex;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        height: 100%;
    }
    
    .signup {
        background-color: #fcbe14;
        color: #1E48B1;
    }
    
    .signup .form-signup {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: auto;
    }
    
    .signup .logo-white {
        margin-bottom: 30px;
        width: 150px;
    }
    
    .signup h1 {
        font-size: 20px;
        margin-bottom: 20px;
        font-weight: bold;
    }
    
    .signup input {
        margin-bottom: 10px;
        background-color: #fff;
        border-color: #1E48B1;
    }
    
    .signup input:focus {
        background-color: #fff;
        border-color: #1af;
    }

    .text {
        text-align: left;
        font-size: 12px;
    }
    
    .birth-area {
        padding-top: 10px;
        padding-bottom: 3px;
    }

    .birth {
        background-color: #1E48B1;
        color: #fff;
        font-size: 15px;
        width: 32%;
        height: 30px;
    }
    
    .btn {
        background-color: #1E48B1;
        color: #fff;
        font-size: 15px;
        margin-top: 10px;
    }
    </style>

</head>
<body class="signup text-center">
    <main class="form-signup">
        <form action="{{ url('login/post')}}" method="POST">
            @csrf
            <img src="logo4_2.png" alt="" class="logo-white">
            <h1>ログインする</h1>
            @isset($errorMsg)
            {{ $errorMsg }}
            <br>
            <br>
            @endisset
            <input type="email" class="form-control" name="mail" placeholder="メールアドレス" maxlength="50" required autofocus>
            <input type="password" class="form-control" name="password" placeholder="パスワード" minlength="8" maxlength="16" required>
            <button class="w-100 btn btn-lg" type="submit">ログイン</button>
            <p class="mt-3 mb-2"><a href="../signup">会員登録する</a></p>
            <p class="mt-2 mb-3 text-muted">&copy; 2021</p>
        </form>
    </main>
</body>
<script>
    history.pushState(null, null, location.href);
    window.addEventListener('popstate', (e) => {
        history.go(1);
    });
</script>
</html>