<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="web/css/bootstrap.min.css">
    <!--<link rel="stylesheet" href="style.css">-->
    <script type="text/javascript" src="web/js/jquery-3.2.1.js"></script>
    <script type="text/javascript" src="web/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="web/js/moment.min.js"></script>
    <script type="text/javascript" src="web/js/Chart.min.js"></script>
    <script type="text/javascript" src="web/js/Chartjs/samples/utils.js"></script>
    <script type="text/javascript" src="web/js/chartjs-plugin-streaming.min.js"></script>
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
    <title>Asterisk</title>
</head>
<body>
<h1> <br /> </h1>
<nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navi" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                    <!--
                <a href="#" class="navbar-brand">
                    <img src="工務室マーク（御誕生日）.jpg" alt="ロゴ" style="height:100%;">
                </a>
                -->
            </div>

            <div class="collapse navbar-collapse" id="bs-navi">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">TOPページ</a></li>
                    <!--
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">お知らせ一覧<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="today.php">本日のお知らせ</a></li>
                            <li><a href="yesterday.php">昨日のお知らせ</a></li>
                            <li><a href="ototoi.php">一昨日のお知らせ</a></li>
                            <li><a href="kakonoosirase.php">過去のお知らせ</a></li>
                        </ul>
                    </li>
                    -->
                    <li><a href="bangou.php">電話番号管理</a></li>
                    <li><a href="cdr_to.php">発呼情報</a></li>
                    <li><a href="cdr_from.php">着呼情報</a></li>
                    <li><a href="admin.php">管理者画面</a></li>
                </ul>
            </div>
        </div>
    </nav>
