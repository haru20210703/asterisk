<?php
 //セッションの開始
 require_once('startsession.php');
 //ヘッダの挿入
 $page_title = 'サインアップ！';
 require_once('header.php');
 require_once('appvars.php');
 require_once('connectvars.php');
 //案内メニューの表示
 require_once('navmenu.php');

 //データベースへの接続
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

 //ユーザーが入力したログインデータの取得
 if (isset($_POST['submit'])) {
 $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
 $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
 $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));

 //すべてのフォームフィールドが空でなく、パスワードが一致しているかを確認
 if (!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
 //データベースに問い合わせ
 $query = "SELECT * FROM mismatch_user WHERE username = '$username'";
 $data = mysqli_query($dbc, $query);

 if (mysqli_num_rows($data) == 0) {
	$query = "INSERT INTO mismatch_user (username, password, join_date) VALUE ('$username', SHA('$password1'), NOW())";
	mysqli_query($dbc, $query);
	echo '<p>アカウントを作成しました。プロフィールを<a href="editprofile.php">編集</a>する事ができます。</p>';
	mysqli_close($dbc);
	exit();
	}
	else{
	//ユーザ名が一意出ないのでエラーメッセージ
	echo '<p class="error">このユーザー名はすでに使われています。別のユーザー名をご利用下さい。</p>';
	$username = "";
	}
 }
 else{
 echo '<p class="error">エラー：サインアップにはすべてのデータを入力する必要があります。パスワードは２回入力して下さい。</p>';
 }
 }
 mysqli_close($dbc);
?>

 <!DOCTYPE html>
 <html lang="ja">
 <head>
 <meta charset="UTF-8">
 </head>
 <body>
 <p>ユーザ名とパスワードを入力してミスマッチサイトにサインアップして下さい。</p>
 <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
 <fieldset>
 <legend>登録情報</legend>
 <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username ?>" /><br />
 <label for="password1">パスワード</label>
 <input type="password" id="password1" name="password1" /><br />
 <label for="password2">パスワード（もう一度）</label>
 <input type="password" id="password2" name="password2" /><br />
 </fieldset>
 <input type="submit" value="サインアップ" name="submit">
<?php
 require_once('footer.php');
?>

