<?php
 echo '<hr /><center>';
 if (isset($_SESSION['username'])) {
 echo '<a href="index.php">ホーム</a>・';
 echo '<a href="admin.php">管理者画面</a>・';
 echo '<a href="gaisyutujyoukyou.php">現在の外出状況確認</a>・';
 echo '<a href="gaisyutusyuukei.php">全ての外出状況確認</a>・';
 echo '<a href="nyuutaisitu.php">工務室要員入退室等管理</a>・';
 echo '<a href="basyotouroku.php">外出先登録</a>';
 } else {
 echo '<a href="index.php">ホーム</a>・';
 echo '<a href="admin.php">管理者画面</a>';
 }
 echo '</center><hr />';
?>
