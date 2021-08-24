<?php //echo validation_errors(); ?>

<?php echo form_open('var'); ?>
<div class="container">
<h2>更新情報を登録する</h2>
<div class="row">
<div class="col-lg-3">
	編集者:<input type="input" name="name">
</div>
<div class="col-lg-8">
	内容:<textarea name="naiyou" style="width:90%" rows="1"></textarea>
</div>
<div class="col-lg-1">
<input type="submit" class="btn btn-success" name="touroku" value="登録">
</div>
</div>
</div>
