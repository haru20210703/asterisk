<?php
 //セッションの開始
 require_once('startsession.php');

 require_once('header.php');

try{
 require_once('connectvars.php');

 $dbh = null;
 } catch (PDOException $e){
 echo "エラー発生" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
 die();
 }

 //echo '</form>';
 require_once('footer.php');
?>
