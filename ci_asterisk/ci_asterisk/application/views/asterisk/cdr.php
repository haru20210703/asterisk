<?php echo form_open('cdr');?>

<?php //echo validation_errors(); ?>

<div class="container">
<h2>呼情報の確認が出来ます</h2>
<h2>条件で検索する</h2>
<div class="row">
<div class="col-lg-4">
<font>代表番号:<input type="input" name="daihyou" value="<?php echo set_value('daihyou'); ?>"></font>
</div>
<div class="col-lg-4">
        <font>通話開始時間:<input type="date" name="start" value="<?php echo set_value('start'); ?>"></font>
</div>
<div class="col-lg-4">
        <font>通話終了時間:<input type="date" name="end" value="<?php echo set_value('end'); ?>"></font>
</div>
<div class="row text-center">
</div>
</div>
<div class="text-center">
<input type="submit" class="btn btn-success" name="touroku" value="検索">
</div>
</div>
<br>

<div class="text-center mt-2">
<?php if($title === 'dst'): ?>
<input type="submit" class="btn btn-danger h3" name="cdr" value="着呼情報">　<input type="submit" class="btn btn-primary" name="cdr" value="発呼情報">
<?php else: ?>
<input type="submit" class="btn btn-primary" name="cdr" value="着呼情報">　<input type="submit" class="btn btn-danger h3" name="cdr" value="発呼情報">
<?php endif; ?>
</div>

<?php if(!empty($data)):?>
<div class="container">
	<?php foreach($data as $key => $value): ?>
		<?php
		if($title === 'src')
		{
			if($value === reset($data) || $bangou !== $value['src'])
			{
				$bangou = $value['src'];
				echo '<br><hr>';
				echo '<font class="text-center h4">番号:'.$bangou.'</font>';
			}
		}
		else
		{
			if($value === reset($data) || $bangou !== $value['dst'])
			{
				$bangou = $value['dst'];
				echo '<br><hr>';
				echo '<font class="text-center h4">番号:'.$bangou.'</font>';
			}
		}
		?>
	<div class="row <?php echo $this->asterisk_model->get_call_count($title, $value['daihyou'], $value['start'])?>">
		<div class="col-lg-3 mt-1">
			<font>通話開始時間:<?php echo $value['start'];?></font>
		</div>
		<div class="col-lg-3 mt-1">
			<font>通話終了時間:<?php echo $value['end'];?></font>
		</div>
		<div class="col-lg-3 mt-1">
			<?php $time = $this->asterisk_model->get_second($value['start'], $value['end']); ?>
			<font>通話時間:<?php echo $time;?></font>
		</div>
		<div class="col-lg-3 mt-1">
			<font>通話先:<?php echo ($title === 'src') ? $value['dst'] : $value['src'];?></font>
		</div>
	</div>
	<?php endforeach; ?>
</div>

<?php else: ?>

情報がありません。

<?php endif; ?>

<!--呼情報をグラフで表示-->
<canvas id="myChart"></canvas>
<script>
	var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
		type: 'bar',
		data: {
		labels: [
			<?php
                	foreach($hour_calls as $key => $value){
				echo '"'.$value['start'].'時 '.$value['count'].'回",';
			}
			?>
                        ],
               	datasets: [{
                	label: "時間別呼情報",
                	backgroundColor: 'rgb(255,99,132)',
               		data: [
               			<?php
                       		foreach($hour_calls as $value){
                        		echo '"'.$value['count'].'",';
				}
				?>
                                ],
                        }]
                },
                options:{
			}
		});
</script>
総合計<?php echo array_sum(array_column($hour_calls, 'count')); ?>回
