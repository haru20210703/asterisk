<?php
 //セッションの開始
 require_once('startsession.php');
 //ヘッダの挿入
 $page_title = 'ログイン！';
 require_once('header.php');
 require_once('appvars.php');
 //案内メニューの表示
 require_once('PDO_navmenu.php');

 //エラーメッセージの設定
 $error_msg = "";

 //クッキーをチェックし、すでにログインしたかを確認
 if (!isset($_SESSION['user_id'])){
	if (isset($_POST['submit'])){


 //ユーザーが入力したログインデータの取得
 $user_username = $_POST['username'];
 $user_password = $_POST['password'];

 //ユーザー名とパスワードをデータベースから探す
 if (!empty($user_username) && !empty($user_password)) {
 //データベースへの接続
 try{
 require_once('PDO_connectvars.php');
 $sql = "SELECT user_id, username, password FROM mismatch_user WHERE username = '$user_username'";
 $stmt = $dbh->query($sql);
 $result = $stmt->fetch(PDO::FETCH_ASSOC);
 if (password_verify($user_password, $result['password'])) {
        //マッチ行があればログインできる
	$_SESSION['user_id'] =  $result['user_id'];
	$_SESSION['username'] = $result['username'];
	setcookie('user_id', $result['user_id'], time() + (60 * 60 * 24 * 30));
	setcookie('username', $result['username'], time() + (60 * 60 * 24 * 30));
	//サイトへの誘導
	$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/PDO_index.php';
	header('Location: ' . $home_url);
        $dbh = null;
	}
	else{
 	//ログインデータの間違いに対してのエラーメッセージ
	$error_msg = 'エラー：正しいユーザ名とパスワードを入力してください。';
	}
 } catch (PDOException $e){
 echo "エラー発生：" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
 die();
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
