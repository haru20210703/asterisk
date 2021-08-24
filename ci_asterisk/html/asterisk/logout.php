<?php
 //ユーザがログインしている場合、セッション変数を削除してログアウト
 session_start();
 if (isset($_SESSION['user_id'])) {
	$_SESSION = array();
 //セッションのクッキーも削除
 if (isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '', time() - 3600);
	}
	session_destroy();
 }
 //１時間前までのクッキーを削除
 setcookie('user_id', '', time() - 3600);
 setcookie('username', '', time() - 3600);
 //ホームページへの移動
 $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
 header('Location: ' . $home_url);
?>
