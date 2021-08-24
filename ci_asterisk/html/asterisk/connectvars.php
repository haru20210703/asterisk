<?php
 //データベース接続の設定
 $host = 'localhost';
 $user = 'asterisk';
 $pass = 'asterisk';
 $dbname = 'asterisk';

 //作業用データベース
 //$dbname = 'gaisyutu_admin';

 $dbh = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8', $user, $pass);
 $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
 $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
