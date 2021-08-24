<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery-3.2.1.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <style media="screen">
.skyblue{
background: skyblue;
height: 100px;
text-align: center;
line-height: 100px;
}
.pink{
background: pink;
height: 100px;
text-align: center;
line-height: 100px;
}
.breadcrumb { background:transparent;}
.breadcrumb li+li:before {  content:'>';}

</style>
    <title><?php if(isset($title)): echo $this->escape($title) . ' - ';
    endif; ?>Asterisk</title>
</head>

<body>
    <div id="nav">
        <p>
            <?php if($session->isAuthenticated()): ?>
            <a href="<?php echo $base_url; ?>/">ホーム</a>
            <a href="<?php echo $base_url; ?>/account">アカウント</a>
            <?php else: ?>
            <a href="<?php echo $base_url; ?>/account/signin">ログイン</a>
            <a href="<?php echo $base_url; ?>/account/signup">アカウント登録</a>
            <?php endif; ?>
        </p>
    </div>

    <div id="main">
        <?php echo $_content;?>
    </div>


</body>
</html>