<?php echo form_open('admin');?>

<div class="text-center mt-2">
<?php if($title === 'conf'): ?>
<input type="submit" class="btn btn-danger h3" name="dir" value="conf">　<input type="submit" class="btn btn-primary" name="dir" value="tftp">
<input type="hidden" name="select_dir" value="conf">
<?php else: ?>
<input type="submit" class="btn btn-primary" name="dir" value="conf">　<input type="submit" class="btn btn-danger h3" name="dir" value="tftp">
<input type="hidden" name="select_dir" value="tftp">
<?php endif; ?>
</div>

<div class="container">
<h4>asteriskの設定の変更が出来ます。（/etc/asterisk もしくは /var/lib/tftpboot 内のファイルが編集できます）</h4>
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
	<textarea name="contents" style="width:100%" rows="20"><?php echo $text; ?></textarea><br>
	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#textModal" data-bs-whatever="@mdo">保存</button>
	<input type="submit" class="btn btn-primary" name="back" value="バックアップを開く">
<?php if($title === 'tftp'): ?>
	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#copyModal" data-bs-whatever="@mdo">複製</button>
<?php endif; ?>
<div>
<?php endif; ?>

<?php if(!empty($files)):?>
<div class="col-lg-8 text-center">
	置き換えるバックアップファイルを選択し、<br>保存ボタンを押して下さい。<br>
	<select name="back_file" style="width:100%" size="20">
	<?php foreach($files as $file): ?>
		<option><?php echo basename($file); ?></option>
	<?php endforeach; ?>
	</select><br>
	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#backModal" data-bs-whatever="@mdo">置き換え</button>
	<input type="submit" class="btn btn-primary" name="back" value="バックアップを開く">
<div>
<?php endif; ?>

<input type="hidden" name="editfile" value="<?php if(!empty($editfile)) echo $editfile ;?>">

<div class="modal fade" id="textModal" tabindex="-1" aria-labelledby="textModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="textModalLabel"><?php echo $editfile;?>の内容が変更されますが<br>よろしいでしょうか</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
        <input type="submit" class="btn btn-primary" name="save" value="はい" />
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="copyModal" tabindex="-1" aria-labelledby="copyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="copyModalLabel"><?php echo $editfile;?>の複製を作成します。</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <form>
        <div class="mb-3">
	  <label for=copyname class="col-form-label">複製ファイル名:</label>
	  <input type="text" class="form-control" name="copyname" id="copyname" value="<?php echo $editfile;?>">
	</div>
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
        <input type="submit" class="btn btn-primary" name="copy" value="複製" />
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="backModal" tabindex="-1" aria-labelledby="backModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="backModalLabel">選択したバックアップファイルに<br>置き換えますか。</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
        <input type="submit" class="btn btn-primary" name="update" value="はい" />
      </div>
     <?php echo form_close(); ?>
    </div>
  </div>
</div>
