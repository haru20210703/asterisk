<?php if(!empty($data)):?>

<?php echo form_open('bangou'); ?>

<div class="container">

<div class="text-center mt-2"><h3><?php echo $title; ?></h3></div>

<input type="submit" class="btn btn-danger" name="update" value="以下を更新">

	<div class="row">
	<?php foreach($data as $key => $value): ?>
		<div class="col-lg-3 mt-1">
			<font>代表番号:</font><input type="input" name="daihyou[<?php echo $key; ?>]" value="<?php echo $value['daihyou']; ?>">
		</div>
		<div class="col-lg-3 mt-1">
			<font>内線番頭:</font><input type="input" name="bangou[<?php echo $key; ?>]" value="<?php echo $value['bangou']; ?>">
		</div>
		<div class="col-lg-3 mt-1">
			<font>IPアドレス:</font><input type="input" name="address[<?php echo $key; ?>]" value="<?php echo $value['address']; ?>">
		</div>
		<div class="col-lg-3 mt-1">
			<font>備考:</font><input type="input" name="bikou[<?php echo $key; ?>]" value="<?php echo $value['bikou']; ?>">
		</div>
			<input type="hidden" name="id[<?php echo $key; ?>]" value="<?php echo $value['id']; ?>">
	<?php endforeach; ?>
	</div>

<?php else: ?>

<?php echo $title; ?>の情報がありません。<br>

<?php endif; ?>
</div>
