<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="http://<?php echo $_SERVER['SERVER_ADDR']?>/assets/css/bootstrap.min.css">
	<script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_ADDR']?>/assets/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_ADDR']?>/assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_ADDR']?>/assets/js/moment.min.js"></script>
	<script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_ADDR']?>/assets/js/Chart.min.js"></script>
	<script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_ADDR']?>/assets/js/Chartjs/samples/utils.js"></script>
	<script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_ADDR']?>/assets/js/chartjs-plugin-streaming.min.js"></script>
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
				<li class="nav-item"><a class="nav-link" data-bs-toggle="modal" data-bs-target="#logoutModal" data-bs-whatever="@mdo" href="<?php echo base_url();?>admin/logout">ログアウト</a></li>
				<?php endif; ?>
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
            <input type="text" class="form-control" name="user_id" id="recipient-name">
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

<?php echo form_open('user/pass'); ?>
<div class="modal fade" id="passModal" tabindex="-1" aria-labelledby="passModalLabel" aria-hidden="true">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title" id="passModalLabel">ユーザ情報を変更できます</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
    <input type="submit" class="btn btn-primary" name="pass" value="変更" />
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

<?php if(isset($vali_ms) && $this->input->post()): ?>
	<div class="alert alert-danger">
	<?php echo $vali_ms; ?>
<?php endif; ?>

<?php if(isset($search_ms) && $this->input->post()): ?>
	<div class="alert alert-primary">
	<?php echo $search_ms; ?>
<?php endif; ?>

</div>
