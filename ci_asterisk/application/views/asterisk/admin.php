<?php echo form_open('admin');?>
<div class="container">
<div class="row">
<div class="col-lg-4 text-center">
	編集するファイルを選択し、<br>開くボタンを押して下さい。<br>
	<select name="file" style="width:100%" size="20">
	<?php foreach($dir as $file): ?>
		<option><?php echo basename($file); ?></option>
	<?php endforeach; ?>
	</select><br>
	<input type="submit" class="btn btn-primary" name="open" value="開く">
</div>
<?php if(!empty($text)):?>
<div class="col-lg-8 text-center">
	ファイルの内容を編集下のちに、<br>保存ボタンを押して下さい。<br>
	<textarea name="contents" style="width:100%" rows="20">
	<?php echo $text; ?>
	</textarea><br>
	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#textModal" data-bs-whatever="@mdo">保存</button>
<div>
<?php endif; ?>
<input type="hidden" name="editfile" value="<?php echo $editfile ;?>">

<div class="modal fade" id="textModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">内容が変更されますがよろしいでしょうか</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
        <input type="submit" class="btn btn-primary" name="save" value="はい" />
      </div>
     <?php echo form_close(); ?>
    </div>
  </div>
</div>
