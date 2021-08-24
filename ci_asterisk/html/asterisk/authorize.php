<?php
 //セッションの開始
 require_once('startsession.php');

 //ユーザー名とパスワードによる認証
 $username = 'asterisk';
 $password = 'asterisk';

 if(!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
   ($_SERVER['PHP_AUTH_USER'] != $username) || ($_SERVER['PHP_AUTH_PW'] != $password)) {
	//ユーザー名/パスワードが不正なため認証ヘッダを送信
	header('HTTP/1.1 401 Unauthorized');
	header('WWW-Authenticate: Basic realm="Guitar Wars"');
	echo '<a href="index.php">ホームに戻る</a>';
	exit('<h2>外出管理：</h2>エラー：ユーザ名とパスワードを確認して下さい。');
} else {
 $_SESSION['username'] = $username;	
}
?>
