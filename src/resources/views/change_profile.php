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
    <title>ユーザー情報変更画面</title>
    <meta name="description" content="会員登録画面です">
    <style type="text/css">
    body.signup {
        display: flex;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        height: 100%;
    }
    
    .signup {
        background: #fcbe14;
        /* background: #fddea5; */
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
        margin-bottom: 15px;
        font-weight: bold;
    }
    
    .signup input {
        margin-bottom: 10px;
        border-color: #1E48B1;
        color: #fcbe14;
    }
    
    .signup input:focus {
        border-color: #1af;
        color: #fff;
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
        font-size: 15px;
        width: 32%;
        height: 30px;
    }
    
    .btn {
        background-color: #1E48B1;
        color: #fff;
        font-size: 15px;
    }
    .logo-img {
        width: calc(100% - 90px);
        border-left: 1px solid #eef;
        border-right: 1px solid #eef;
        text-align: center;
        max-width: 100px;
        width: 100%;
        max-height: 100px;
        height: 100%;
        border-radius: 50%;
        border: 0.2px solid #fcbe14;
    }
    </style>
</head>
<body class="signup text-center">
    <main class="form-signup">
        <form action="sign-up.php" method="post">
            <img src="logo4_2.png" alt="" class="logo-white">
            <h1>ユーザー情報を変更する</h1>
            <input type="text" class="form-control" name="nickname" placeholder="ニックネーム" maxlength="50" required autofocus>
            <input type="email" class="form-control" name="email" placeholder="メールアドレス" maxlength="50" required>
            <div class="birth-area">    
                <p>生年月日：</p>
            </div>
            <p class="text mt-2 mb-3 text-muted">※ パスワードは8-16文字に設定してください。</p>
            <input type="password" class="form-control" name="password" placeholder="現在のパスワード" minlength="8" maxlength="16" required>
            <input type="password" class="form-control" name="password" placeholder="新しいパスワード" minlength="8" maxlength="16" required>
            <input type="password" class="form-control" name="password" placeholder="新しいパスワード(再入力)" minlength="8" maxlength="16" required>
            <div class="mb-0 select">
                <input type="file" name="image" class="form-control form-control-sm">
            </div>
            <button class="w-100 btn btn-lg" type="submit">変更する</button>
            <p class="mt-2 mb-3 text-muted">&copy; 2021</p>
        </form>
    </main>
</body>
</html>