# Find a hobbys✌️

<img width="1114" alt="スクリーンショット 2021-11-13 16 59 29" src="https://user-images.githubusercontent.com/78466273/141611076-3ab134c0-5d98-448e-8564-e2a890dd610e.png">

# hobbys(ホビーズ)とは
hobbysは趣味を共有したい人同士をマッチングするアプリケーションです。

共有したい趣味を投稿し、投稿にいいねをする事でマッチングが成立します。

問い合わせから投稿者にメールを送付し、趣味友達を作りましょう！

# 主な機能
・会員登録機能

・会員登録変更機能

・ログイン機能

・趣味投稿&投稿内容変更機能

・My投稿一覧表示機能

・いいね機能

・問い合わせ機能


# 環境
・Laravel Framework 8.56.0

・Apache Ver 2.4.46

<!-- ・mysql  Ver 5.7.34 -->

・PHP Ver 7.4.14

# 導入方法
1. リポジトリからクローンします。

```bash
$  git clone https://github.com/takilll/team35.git
```
2. composerをインストールします。

```bash
$ composer install
```
3. .envファイルDB接続などをローカル用に書き換え下さい。

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ご自身でデータベースを作成下さい。
DB_USERNAME=ご自身のユーザーネーム
DB_PASSWORD=ご自身のパスワード
```
4. .envファイルの用意ができたら、下記のコマンドでアプリケーションキーの初期化をおこないます。

```bash
$ php artisan key:generate
```

5. マイグレーションの実施

```bash
$ php artisan migrate
```

6. Gmailを利用したLaravelのメール送信設定

　　[参照記事をご確認下さい](https://qiita.com/hiro5963/items/df062ab19e8ceba4573f)

# Author
Keiichiro.Kimoto

# License

"hobbys" is under team35 license.

# Finally
Thank you for reading👌
