<?php
 //セッションの開始
 require_once('startsession.php');
 //ヘッダの挿入
 $page_title = 'ログイン！';
 require_once('header.php');
 require_once('appvars.php');
 require_once('connectvars.php');
 //案内メニューの表示
 require_once('navmenu.php');

 //エラーメッセージの設定
 $error_msg = "";

 //クッキーをチェックし、すでにログインしたかを確認
 if (!isset($_SESSION['user_id'])){
	if (isset($_POST['submit'])){

 //データベースへの接続
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

 //ユーザーが入力したログインデータの取得
 $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
 $user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));

 //ユーザー名とパスワードをデータベースから探す
 if (!empty($user_username) && !empty($user_password)) {
 $query = "SELECT user_id, username FROM mismatch_user WHERE username = '$user_username' AND password = SHA('$user_password')";
 $data = mysqli_query($dbc, $query);

 if (mysqli_num_rows($data) == 1) {
	//マッチ行があればログインできる
	$row = mysqli_fetch_array($data);
	$_SESSION['user_id'] =  $row['user_id'];
	$_SESSION['username'] = $row['username'];
	setcookie('user_id', $row['user_id'], time() + (60 * 60 * 24 * 30));
	setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30));
	//サイトへの誘導
	$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
	header('Location: ' . $home_url);
	}
	else{
 	//ログインデータの間違いに対してのエラーメッセージ
	$error_msg = 'エラー：正しいユーザ名とパスワードを入力してください。';
	}
 }
 else{
 $error_msg = 'ユーザ名とパスワードを入力してください';
 }
}
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ミスマッチ：ログイン</title>
<link rel="styleseet" type="text/css" href="style.css" />
</head>
<body>
 <h3>ミスマッチ：ログイン</h3>
<?php
 //クッキーが空の場合、メッセージとログインフォームの表示、そうでなければログイン成功
 if (empty($_COOKIE['user_id'])) {
	echo '<p class="error">' .$error_msg . '</p>';
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
 <fieldset>
 <legend>ログイン</legend>
 <label for="username">ユーザ名:</label>
 <input type="text" id="username" name="username" value="<?php if (!empty($user_username)) echo $user_username; ?>" /><br />
 <label for="password">パスワード:</label>
 <input type="password" id="password" name="password" />
 </fieldset>
 <input type="submit" value="ログイン" name="submit" />
 </form>
<?php
 }
 else{
 //ログイン中である事を確認
 echo ('<p class="login">' . $_COOKIE['username'] . 'としてログイン中です。</p>');
}
 require_once('footer.php');
?>
