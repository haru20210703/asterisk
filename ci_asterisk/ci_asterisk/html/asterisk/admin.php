<?php
 require_once('authorize.php');
 //セッションの開始
 require_once('startsession.php');

 require_once('syuukei.php');

 //ヘッダの挿入
 $page_title = '名前をクリックすれば、外出状況が確認できます。（管理者権限を解除する為には、一度全てのページを閉じて下さい）';
 require_once('header.php');
 require_once('appvars.php');

 //案内メニューの表示
 require_once('navmenu.php');

try{
 require_once('connectvars.php');

 //外出上限回数の取得
 $sql = "SELECT * FROM T_admin WHERE admin_id = 1";
 $stmt = $dbh->query($sql);
 $result = $stmt->fetch(PDO::FETCH_ASSOC);
 $kaisuu_jyouken = $result['jyouken_int'];

 $sql = "SELECT * FROM T_kojin
	 INNER JOIN T_kisei USING (kisei_id)
	 WHERE zaiseki = 0
	 ORDER BY kisei_id";
 $stmt = $dbh->query($sql);
 $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

 echo $result[0]['kisei'] . '<br>';

 foreach ($result as $row){

	if(isset($kisei_id)){
		if ($kisei_id != $row['kisei_id']){
			echo '<br><hr>'. $row['kisei'] . '<br>';
		}
	}

	$kojin_id = $row['kojin_id'];

	$year = date('Y');
	$month = date('n');
	$day = date('d');
	$to_month = date('Ymd', mktime(0, 0, 0, $month, 0, $year));
	$next_month = date('Ymd', mktime(0, 0, 0, $month + 1, 0, $year));

	$sql = "SELECT * FROM T_gaisyutu 
		WHERE kojin_id = :kojin_id && touroku = 0 && dejikan > $to_month";// && dejikan < $next_month";
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':kojin_id', htmlspecialchars($kojin_id, ENT_QUOTES, 'UTF-8'), PDO::PARAM_INT);
	$stmt->execute();
	$kaisuu = $stmt->rowCount();

	$jyouken = $kaisuu_jyouken - $kaisuu;
	if($jyouken <= 0) $jyouken =0;

	if($row['iride'] == 0){

		switch($jyouken){
		case 0:
			echo '<a class="name" href="gaisyutu_kanri.php?id=' . htmlspecialchars($row['kojin_id'], ENT_QUOTES, 'UTF-8') . '&out=0">
				<span style="background-color:yellow;">' . $row['name'] .':'. $kaisuu .'回</span></a>　' ;
			break;
		case 1:
			echo '<a class="name" href="gaisyutu_kanri.php?id=' . htmlspecialchars($row['kojin_id'], ENT_QUOTES, 'UTF-8') . '&out=1">
				<span style="background-color:aquamarine;">' . $row['name'] .':'. $kaisuu .'回</span></a>　' ;
			break;
		default:
			echo '<a class="name" href="gaisyutu_kanri.php?id=' . htmlspecialchars($row['kojin_id'], ENT_QUOTES, 'UTF-8') . '">
				' . $row['name'] .':'. $kaisuu .'回</a>　' ;
			break;
		}
	
	} else {
 		echo '<a href="gaisyutu_kanri.php?id=' . htmlspecialchars($row['kojin_id'], ENT_QUOTES, 'UTF-8') . '"><span style="background-color:salmon;">' . $row['name'] .':'. $kaisuu .'回</span></a>　' ;
	}

	$kisei_id = $row['kisei_id'];
 }

 } catch (PDOException $e){
 echo "エラー発生" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
 die();
 }

 //echo '</form>';
 require_once('footer.php');
?>