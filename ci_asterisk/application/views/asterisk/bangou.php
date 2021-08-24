<?php echo form_open('bangou'); ?>
<div class="container">
<h2> 新しい番号を登録する</h2>
<div class="row">
<div class="col-lg-3">
	<font>代表番号:<input type="input" name="touroku_daihyou"></font>
</div>
<div class="col-lg-3">
	<font>内線番号:<input type="input" name="touroku_bangou"></font>
</div>
<div class="col-lg-3">
	<font>IPアドレス:<input type="input" name="touroku_address"></font>
</div>
<div class="col-lg-3">
	<font>備考:<input type="input" name="touroku_bikou"></font>
</div>
</div>
<input type="submit" class="btn btn-success" name="touroku" value="登録">
</div>
