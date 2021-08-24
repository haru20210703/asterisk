﻿<?php
//require_once('authorize.php');
//セッションの開始
//require_once('startsession.php');
if(!isset($to)){
	$to = 0;
}
//ヘッダの挿入
$page_title = '着呼情報です。検索が出来ます。';
require_once('header.php');
//require_once('appvars.php');

//案内メニューの表示
//require_once('navmenu.php');

//発着呼した時間を調査する為の変数
$h7 =
$h8 =
$h9 =
$h10 =
$h11 =
$h12 =
$h13 =
$h14 =
$h15 =
$h16 =
$h17 =
$h18 = 0;

//検索フォームが送られた場合の動作
if(!empty($_POST['usersearch'])){
	$user_search = $_POST['usersearch'];
}else{
	$user_search = '';
}
if(!empty($_POST['startday'])){
	$startday = $_POST['startday'];
}else{
	$startday = 0;
}
if(!empty($_POST['endday'])){
	$endday = $_POST['endday'];
}else{
	$endday = date('Y-m-d');
}
?>

<form method='post' action="">
<div class="container">
<div class="row">
<div class="col-lg-4">
<label for="usersearch">代表番号で検索:<input type="text" id="usersearch" name="usersearch" value="<?php if(!empty($user_search)) echo $user_search; ?>">
</div>
<div class="col-lg-4">
検索開始日：<input type="date" name="startday" value="<?php if(!empty($startday)) echo $startday; ?>">
</div>
<div class="col-lg-4">
検索終了日：<input type="date" name="endday" value="<?php echo $endday; ?>">
</div>
</div>
</div>
<div class="text-center">
<input type="submit"  class="btn btn-primary" value="検索" name="submit">
</div>
</form>

<?php
//functionはカスタム関数を作るときの予約語
//ココでは問い合わせ文のカスタム関数を作る
//functionの次に関数名（今回はbuild_query）　（）内に引数を指定する

function build_query($user_search,$to) {
	if($to == 1){
		$search_query = "SELECT * FROM cdr
		LEFT JOIN telephone ON cdr.src = telephone.bangou
		WHERE start > 1 && dst IS NOT null && answer IS NOT NULL && disposition = 'ANSWERED'";
	}else{
		$search_query = "SELECT * FROM cdr
		LEFT JOIN telephone ON cdr.dst = telephone.bangou
		WHERE start > 1 && dst IS NOT null && answer IS NOT NULL && disposition = 'ANSWERED'";
	}
	
	//str_replace関数は、文字列の中の置き換えたい文字を置き換える事が出来る
	//第一引数に置き換えたい文字　第二引数に置き換えた後の文字　第三引数に置き換え対象の文字列
	$clean_search = str_replace(',', '　', $user_search);
	
	//explode関数で文字列を部分文字列に分解（最初の引数'　'が分離子（デリミッタ））
	$search_words = explode('　', $clean_search);
	
	$final_search_words = array();
	
	//$search_wordsの文字列数をカウントし、その分処理を繰り返す
	if (count($search_words) > 0) {
		foreach ($search_words as $word) {
			//$wordの要素が空でなければ、final_search_wordsという配列に入れる
			if (!empty($word)){
				//[]演算子はarray_push()関数と同じような動作をし、新しい要素を配列の最後に追加してくれる
				$final_search_words[] = $word;
			}
		}
	}
	
	$where_list = array();
	
	//先ほど取り出した$final_search_words配列をwhere_list配列に入れなおす
	if (count($final_search_words) > 0){
		foreach ($final_search_words as $word){
			//問い合わせ文の一部を取り出して検索するLIKEを使用し、%%で問い合わせ文を囲む
			$where_list[] = "daihyou LIKE '%$word%'";
		}
	}
	
	//implode関数は、文字列の配列を取って、一つの文字列を作る
	//下の記述では$where_listの配列の間に' OR'を入れて配列を作る
	$where_clause = implode(' OR ', $where_list);
	
	//$where_clause変数に問い合わせ文が設定されていれば、$search_query変数に追加
	if (!empty($where_clause)){
		$search_query .= " && $where_clause";
	}
	
	//最後に$search_queryを返す
	return $search_query;
}

try{
	require_once('connectvars.php');
	
	$search_query = build_query($user_search,$to);
	//もし開いたサイトがcdr_to.phpならば
	if($to == 1){
		$search_query .= ' ORDER BY src , calldate DESC';
	}else{
		$search_query .= ' ORDER BY dst , calldate DESC';
	}
	$stmt = $dbh->query($search_query);
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	//print_r($result);
	$i = 0;
	$e = 0;
	$kosuu2 = 0;
	$kosuu3 = 0;
	$kosuu4 = 0;
	$kosuu5 = 0;
	
	$endday = date('Y-m-d' , mktime(0, 0, 0, date('n' , strtotime($endday)) , date('j' , strtotime($endday)) + 1 , date('Y' , strtotime($endday))));
	
	if($to == 1){
		echo '<h3><div class="text-center">' . $result[0]['src'] . ' (' . $result[0]['daihyou'] . '):'.$result[0]['bikou'].'</div></h3>';
	}else{
		echo '<h3><div class="text-center">' . $result[0]['dst'] . ' (' . $result[0]['daihyou'] . '):'.$result[0]['bikou'].'</div></h3>';
	}
	echo '<div class="container">';
	echo '<div class="row">';
	foreach ($result as $row){
		
		if($to == 1){
			$ko = $row['src'];
		}else{
			$ko = $row['dst'];
		}
		//呼のダブりを調査するクエリ

		if($to == 1){
			$sql = "SELECT COUNT(start)
			FROM cdr 
			LEFT JOIN telephone ON cdr.src = telephone.bangou
			WHERE start < :start1 && end > :start2 && (daihyou = :daihyou || dst = :ko) && disposition = 'ANSWERED'";
		}else{
			$sql = "SELECT COUNT(start)
			FROM cdr 
			LEFT JOIN telephone ON cdr.dst = telephone.bangou
			WHERE start < :start1 && end > :start2 && (daihyou = :daihyou || src = :ko) && disposition = 'ANSWERED'";
		}

		$stmt = $dbh->prepare($sql);
		$stmt->bindValue(':start1',htmlspecialchars($row['start'],ENT_QUOTES,'UTF-8'),PDO::PARAM_STR);
		$stmt->bindValue(':start2',htmlspecialchars($row['start'],ENT_QUOTES,'UTF-8'),PDO::PARAM_STR);
		$stmt->bindValue(':ko',htmlspecialchars($ko,ENT_QUOTES,'UTF-8'),PDO::PARAM_INT);
		$stmt->bindValue(':daihyou',htmlspecialchars($row['daihyou'],ENT_QUOTES,'UTF-8'),PDO::PARAM_STR);
		$stmt->execute();
		$result2 = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if(isset($hikaku)){
			if ($hikaku != $ko){
				echo '</div>';
				echo '<div class="text-right">';
				echo $i . '回
				<font color="blue"> ２回線'.$kosuu2.'回</font>
				<font color="green">　３回線'.$kosuu3.'回</font>
				<font color="purple">　４回線'.$kosuu4.'回</font>
				<font color="red">　５回線以上'.$kosuu5.'回</font>';
				$kosuu2 = 0;
				$kosuu3 = 0;
				$kosuu4 = 0;
				$kosuu5 = 0;
				echo '</div>';
				echo '</div>';
				echo '<hr><h3><div class="text-center">' . $ko . ' (' . $row['daihyou'] . '):'.$row['bikou'].'</div></h3>';
				echo '<div class="container">';
				echo '<div class="row">';
				$i = 0;
			}
		}
		
		if(isset($start)){
			if($start == $row['start']){
				if($to == 1){
					$hikaku = $row['src'];
				}else{
					$hikaku = $row['dst'];
				}
				continue;
			}
		}
		if($startday > $row['start'] || $endday < $row['end']){
			if($to == 1){
				$hikaku = $row['src'];
			}else{
				$hikaku = $row['dst'];
			}
			continue;
		}
		
		//呼のダブリの数によって表示する文字の色を変える設定
		switch($result2['COUNT(start)']){
			case 1:
				echo '<font color="blue">';
				$kosuu2++;
			break;
			case 2:
				echo '<font color="green">';
				$kosuu3++;
			break;
			case 3:
				echo '<font color="purple">';
				$kosuu4++;
			break;
			case 4:
				echo '<font color="red">';
				$kosuu5++;
			break;
		}
		
		echo '<div class="col-lg-3">';
		echo '　通話開始時間：' . $row['start'];
		echo '</div>';
		echo '<div class="col-lg-3">';
		echo '　通話終了時間：' . $row['end'];
		echo '</div>';
		$time = date('i分s秒' , strtotime($row['end']) - strtotime($row['start']));
		echo '<div class="col-lg-3">';
		echo '　通話時間：' . $time;
		echo '</div>';
		echo '<div class="col-lg-3">';
		
		//cdrから発呼した時間を抽出し、時間変数をカウントアップする
		switch((int)date('H', strtotime($row['start']))){
			case 7:
				$h7++;
			break;
			case 8:
				$h8++;
			break;
			case 9:
				$h9++;
			break;
			case 10:
				$h10++;
			break;
			case 11:
				$h11++;
			break;
			case 12:
				$h12++;
			break;
			case 13:
				$h13++;
			break;
			case 14:
				$h14++;
			break;
			case 15:
				$h15++;
			break;
			case 16:
				$h16++;
			break;
			case 17:
				$h17++;
			break;
			case 18:
				$h18++;
			break;
		}
		
		if($to == 1){
			echo '　通話先：' . $row['dst'];			
		}else{
			echo '　通話元：' . $row['src'];
		}
		echo '</div>';
		
		if($result2['COUNT(start)'] >= 1){
			echo '</font>';
		}
		
		if($to == 1){
			$hikaku = $row['src'];
		}else{
			$hikaku = $row['dst'];
		}
		$start = $row['start'];
		$i++;
		$e++;
	}
	echo '<div class="text-right">';
	echo $i . '回
	<font color="blue"> ２回線'.$kosuu2.'回</font>
	<font color="green">　３回線'.$kosuu3.'回</font>
	<font color="purple">　４回線'.$kosuu4.'回</font>
	<font color="red">　５回線以上'.$kosuu5.'回</font><br>';
	
	//発着呼変数を配列にする
	$hours = array(
		$h7,
		$h8,
		$h9,
		$h10,
		$h11,
		$h12,
		$h13,
		$h14,
		$h15,
		$h16,
		$h17,
		$h18,
	);
	
	?>
	
	<!--呼情報をグラフで表示-->
	<canvas id="myChart"></canvas>
	<script>
	var ctx = document.getElementById('myChart').getContext('2d');
	var chart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: [
				<?php
				for($i = 7,$k = 0; $i < 19; $i++,$k++){
					echo '"'.$i.'時 '.$hours[$k].'回",';
				}
				?>
			],
			datasets: [{
				label: "時間別呼情報",
				backgroundColor: 'rgb(255,99,132)',
				data: [
					<?php
					foreach($hours as $value){
						echo '"'.$value.'",';
					}
					?>
				],
			}]
		},
		options:{
			
		}
	});
	</script>
	
	<?php
	/*発着呼情報をテーブルで表示
	echo '<table class="table">';
	echo '<tr><th>7時</th>';
	echo '<th>8時</th>';
	echo '<th>9時</th>';
	echo '<th>10時</th>';
	echo '<th>11時</th>';
	echo '<th>12時</th>';
	echo '<th>13時</th>';
	echo '<th>14時</th>';
	echo '<th>15時</th>';
	echo '<th>16時</th>';
	echo '<th>17時</th>';
	echo '<th>18時</th></tr><tr>';
	echo '<tr>';
	foreach($hours as $value){
		echo '<td>'.$value.'</td>';
	}
	echo '</tr></table>';*/
	
	echo '総回数' . $e . '回';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	
} catch (PDOException $e){
	echo "エラー発生" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
	die();
}
//echo '</form>';
require_once('footer.php');
?>