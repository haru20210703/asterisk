<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>">
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.2.1.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/moment.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/Chart.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/Chartjs/samples/utils.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/chartjs-plugin-streaming.min.js');?>"></script>
	<style media="screen"></style>
	<title>asterisk</title>
</head>
<body>
<br>
<br>
<br>
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
	<div class="container-fluid">
			<button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#bs-navi" aria-expanded="false">
			<span class="navbar-toggler-icon"></span>
			</button>

		<!--<div class="collapse navbar-collapse" id="bs-navi">-->
		<div class="collapse navbar-collapse" id="bs-navi">
			<ul class="nav navbar-nav">
				<li class="nav-item"><a class="nav-link" href="<?php echo base_url();?>">TOPページ</a></li>
				<li class="nav-item"><a class="nav-link" href="<?php echo base_url();?>bangou">電話番号管理</a></li>
				<li class="nav-item"><a class="nav-link" href="<?php echo base_url();?>cdr">呼情報</a></li>
				<li class="nav-item"><a class="nav-link <?php if(!$this->login_session->is_logged_in()) echo 'disabled'; ?>" href="<?php echo base_url();?>var">アップデート管理</a></li>
				<li class="nav-item"><a class="nav-link <?php if(!$this->login_session->is_logged_in()) echo 'disabled'; ?>" href="<?php echo base_url();?>admin">設定管理</a></li>
				<?php if($this->login_session->is_logged_in()): ?>
				<li class="nav-item"><a class="nav-link" data-bs-toggle="modal" data-bs-target="#passModal" data-bs-whatever="@mdo" href="<?php echo base_url();?>admin/pass">ユーザ管理</a></li>
				<li class="nav-item"><a class="nav-link" data-bs-toggle="modal" data-bs-target="#addModal" data-bs-whatever="@mdo" href="<?php echo base_url();?>admin/add">ユーザ追加</a></li>
				<li class="nav-item"><a class="nav-link" data-bs-toggle="modal" data-bs-target="#logoutModal" data-bs-whatever="@mdo" href="<?php echo base_url();?>admin/logout">ログアウト</a></li>
				<?php endif; ?>
				<li class="nav-item"><a class="nav-link" href="#" onClick="window.open('about:blank', '_self').close();">閉じる</a><li>
			</ul>
		</div>
		<div class="navbar-right">
			<ul class="nav navbar-nav">
				<?php if($this->login_session->is_logged_in()): ?>
					<li class="nav-item"><a href="admin"><button type="button" class="btn btn-primary" style="width:150px" data-bs-toggle="modal" data-bs-target="#userModal" data-bs-whatever="@mdo">管理者画面</button></a><li>
				<?php else: ?>
					<li class="nav-item"><button type="button" class="btn btn-primary" style="width:150px" data-bs-toggle="modal" data-bs-target="#userModal" data-bs-whatever="@mdo">管理者画面</button><li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</nav>

<?php echo form_open('user/login')?>
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">ユーザ・パスワードを入力してください。</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">user:</label>
            <input type="text" class="form-control" name="name" id="recipient-name">
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">password:</label>
            <input type="password" class="form-control" name="password" id="message-text" />
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
        <input type="submit" class="btn btn-primary" value="開く" />
      </div>
     <?php echo form_close(); ?>
    </div>
  </div>
</div>

<?php echo form_open('user/logout'); ?>
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title" id="logoutModalLabel">ログアウトしてもよろしいでしょうか</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
    <input type="submit" class="btn btn-primary" name="logout" value="ログアウト" />
   </div>
  <?php echo form_close(); ?>
  </div>
 </div>
</div>

<?php echo form_open('user/update'); ?>
<div class="modal fade" id="passModal" tabindex="-1" aria-labelledby="passModalLabel" aria-hidden="true">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title" id="passModalLabel">ユーザ情報を変更できます</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
   </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="now-name" class="col-form-label">現在のユーザ名:</label>
            <input type="text" class="form-control" name="now-name" id="now-name">
          </div>
          <div class="mb-3">
            <label for="new-name" class="col-form-label">新しいユーザ名:</label>
            <input type="text" class="form-control" name="new-name" id="new-name">
          </div>
          <div class="mb-3">
            <label for="now-pass" class="col-form-label">現在のパスワード:</label>
            <input type="password" class="form-control" name="now-pass" id="now-pass" />
          </div>
          <div class="mb-3">
            <label for="new-pass1" class="col-form-label">新しいパスワード:</label>
            <input type="password" class="form-control" name="new-pass1" id="new-pass1" />
          </div>
          <div class="mb-3">
            <label for="new-pass2" class="col-form-label">新しいパスワードの確認:</label>
            <input type="password" class="form-control" name="new-pass2" id="new-pass2" />
          </div>
        </form>
      </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
    <input type="submit" class="btn btn-primary" name="pass" value="変更" />
   </div>
  <?php echo form_close(); ?>
  </div>
 </div>
</div>

<?php echo form_open('user/create'); ?>
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title" id="addModalLabel">ユーザの追加が出来ます</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
   </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="name" class="col-form-label">新しいユーザ名:</label>
            <input type="text" class="form-control" name="name" id="name">
          </div>
          <div class="mb-3">
            <label for="password" class="col-form-label">新しいパスワード:</label>
            <input type="password" class="form-control" name="password" id="password" />
          </div>
          <div class="mb-3">
            <label for="password_re" class="col-form-label">新しいパスワードの確認:</label>
            <input type="password" class="form-control" name="password_re" id="password_re" />
          </div>
        </form>
      </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
    <input type="submit" class="btn btn-primary" name="add" value="追加" />
   </div>
  <?php echo form_close(); ?>
  </div>
 </div>
</div>

<?php if(isset($model) && $model): ?>
	<div class="alert alert-primary">
	<?php echo $message; ?>
<?php elseif(isset($model) && !$model): ?>
	<div class="alert alert-danger">
	<?php echo $message; ?>
<?php endif; ?>

<?php //echo validation_errors();?>
</div>
