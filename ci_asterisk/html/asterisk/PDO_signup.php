<?php
 //セッションの開始
 require_once('startsession.php');
 //ヘッダの挿入
 $page_title = 'サインアップ！';
 require_once('header.php');
 require_once('appvars.php');
 //案内メニューの表示
 require_once('PDO_navmenu.php');

 //ユーザーが入力したログインデータの取得
 if (isset($_POST['submit'])) {
 $username = $_POST['username'];
 $password1 = $_POST['password1'];
 $password2 = $_POST['password2'];
 $password_hash = password_hash($_POST['password1'], PASSWORD_DEFAULT);

 //すべてのフォームフィールドが空でなく、パスワードが一致しているかを確認
 if (!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
 //データベースに問い合わせ
 try{
 require_once('PDO_connectvars.php');
 $sql = "SELECT * FROM mismatch_user WHERE username = '$username'";
 $stmt = $dbh->query($sql);
 $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

 if ($stmt->rowCount() == 0) {
	$sql = "INSERT INTO mismatch_user (username, password, join_date) VALUE (?, ?, NOW())";
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(1, $username, PDO::PARAM_STR);
	$stmt->bindValue(2, $password_hash, PDO::PARAM_STR);
	$stmt->execute();
 	$dbh = null;
	echo '<p>アカウントを作成しました。プロフィールを<a href="editprofile.php">編集</a>する事ができます。</p>';
	exit();
	}
	else{
	//ユーザ名が一意出ないのでエラーメッセージ
	echo '<p class="error">このユーザー名はすでに使われています。別のユーザー名をご利用下さい。</p>';
	$username = "";
	}
 } catch (PDOException $e){
 echo "エラー発生：" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
 die();
 }
}
 else{
 echo '<p class="error">エラー：サインアップにはすべてのデータを入力する必要があります。パスワードは２回入力して下さい。</p>';
 }
 }
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

