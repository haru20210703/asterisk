<?php
//require_once('authorize.php');
//セッションの開始
require_once('startsession.php');

//ヘッダの挿入
$page_title = '電話番号の管理ページです。';
require_once('header.php');

if(isset($_POST['add_name'])){
	$daihyou = $_POST['daihyou'];
	$bangou = $_POST['bangou'];
	$address = $_POST['address'];
	$bikou = $_POST['bikou'];
} else {
	$daihyou = '';
	$bangou = '';
	$address = '';
	$bikou = '';
}

try{
	require_once('connectvars.php');
	
	if(isset($_POST['update'])){
		$i = 0; 
		foreach($_POST['tele'] as $i => $value){
			$sql = "UPDATE telephone SET daihyou = :daihyou, bangou = :bangou, address = :address, bikou = :bikou WHERE id = :id";
			$stmt = $dbh->prepare($sql);
			$stmt->bindValue(':id', htmlspecialchars($value['id'], ENT_QUOTES,'UTF-8'),PDO::PARAM_INT);
			$stmt->bindValue(':daihyou', htmlspecialchars($value['daihyou'], ENT_QUOTES,'UTF-8'),PDO::PARAM_STR);
			$stmt->bindValue(':bangou', htmlspecialchars($value['bangou'], ENT_QUOTES,'UTF-8'),PDO::PARAM_INT);
			$stmt->bindValue(':address', htmlspecialchars($value['address'], ENT_QUOTES,'UTF-8'),PDO::PARAM_STR);
			$stmt->bindValue(':bikou', htmlspecialchars($value['bikou'], ENT_QUOTES,'UTF-8'),PDO::PARAM_STR);
			$stmt->execute();
			$i++;
		}
	}
	
	if(isset($_POST['add_name'])){
		$sql = "SELECT * FROM telephone WHERE address = :address && address IS NULL";
		$stmt1 = $dbh->prepare($sql);
		$stmt1->bindValue(':address', htmlspecialchars($address, ENT_QUOTES,'UTF-8'),PDO::PARAM_STR);
		$stmt1->execute();

		$sql = "SELECT * FROM telephone WHERE bangou = :bangou && bangou IS NOT NULL";
		$stmt2 = $dbh->prepare($sql);
		$stmt2->bindValue(':bangou', htmlspecialchars($bangou, ENT_QUOTES,'UTF-8'),PDO::PARAM_INT);
		$stmt2->execute();


		if($stmt1->rowCount() !== 0){
			echo '<div class="alert alert-danger" role="alert"><strong>警告</strong>：同じIPアドレスが既に登録されている為、登録できません。</div>';
		} else if($stmt2->rowCount() !== 0){
			echo '<div class="alert alert-danger" role="alert"><strong>警告</strong>：同じ電話番号が既に登録されている為、登録できません。</div>';
		} else{		
		$sql = "INSERT INTO telephone(daihyou,bangou,address,bikou) VALUES(:daihyou,:bangou,:address,:bikou)";
		$stmt = $dbh->prepare($sql);
		$stmt->bindValue(':daihyou', htmlspecialchars($daihyou, ENT_QUOTES,'UTF-8'),PDO::PARAM_STR);
		$stmt->bindValue(':bangou', htmlspecialchars($bangou, ENT_QUOTES,'UTF-8'),PDO::PARAM_INT);
		$stmt->bindValue(':address', htmlspecialchars($address, ENT_QUOTES,'UTF-8'),PDO::PARAM_STR);
		$stmt->bindValue(':bikou', htmlspecialchars($bikou, ENT_QUOTES,'UTF-8'),PDO::PARAM_STR);
		$stmt->execute();
		echo '<div class="alert alert-info" role="alert"><strong>成功</strong>：電話番号を登録しました。</div>';
		}
	}
	
	echo '<center><h2>新しい番号を登録する。</h2>';
	echo '<form method="post" action="">';
	echo '<div class="container">';
	echo '<div class="row">';
	echo '<div class="col-lg-3">';
	echo '代表番号：<input type="text" name="daihyou" value="' . $daihyou . '">';
	echo '</div>';
	echo '<div class="col-lg-3">';
	echo '内線番号：<input type="text" name="bangou" value="' . $bangou . '">';
	echo '</div>';
	echo '<div class="col-lg-3">';
	echo 'IPアドレス：<input type="text" name="address" value="' . $address . '">';
	echo '</div>';
	echo '<div class="col-lg-3">';
	echo '備考：<input type="text" name="bikou" value="' . $bikou . '">';
	echo '</div>';
	echo '</div></div><br>';
	echo '<input type="submit" class="btn btn-primary" name="add_name" value="この番号を追加">';
	echo '</form><br>';
	
	echo '<h2>番号の編集が出来ます。</h2>';
	echo '<form method="post" action="">';
	echo '<input type="submit" class="btn btn-primary" name="update" value="以下を更新"><br><br>';
	
	$i = 0;
		$sql = "SELECT * FROM telephone ORDER BY daihyou, bangou, address";
		$stmt = $dbh->query($sql);
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
		foreach ($result as $row){
			echo '<div class="container">';
			echo '<div class="row">';
			echo '<div class="col-lg-3">';
			echo '代表番号：<input type="text" name="tele['.$i.'][daihyou]" value="'. $row['daihyou'] . '">';
			echo '</div>';
			echo '<div class="col-lg-3">';
			echo '内線番号：<input type="text" name="tele['.$i.'][bangou]" value="'. $row['bangou'] . '">';
			echo '</div>';
			echo '<div class="col-lg-3">';
			echo 'IPアドレス：<input type="text" name="tele['.$i.'][address]" value="'. $row['address'] . '">';
			echo '</div>';
			echo '<div class="col-lg-3">';
			echo '備考：<input type="text" name="tele['.$i.'][bikou]" value="'. $row['bikou'] . '">';
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '<input type="hidden" name="tele['.$i.'][id]" value="' .$row['id'] .'"><br>';
			$i++;
		}
	echo '<input type="submit" class="btn btn-primary" name="update" value="以上を更新"><br>';
	echo '</form></center>';
	
	$dbh = null;
} catch (PDOException $e){
	echo "エラー発生" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
	die();
}

require_once('footer.php');
?>
