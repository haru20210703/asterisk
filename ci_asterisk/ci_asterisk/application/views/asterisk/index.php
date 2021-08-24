<div class="container">
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">ようこそ</a>
    <a class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">概要</a>
    <a class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">更新履歴</a>
  </div>

<div class="tab-content alert-success" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
当サイトは、IP電話用のサーバー管理サイトです。<br><br>
以下に、各ページの役割を紹介します。<br><br>
電話番号管理<br>
各所の電話番号の確認・登録・更新を行います。<br><br>
呼情報<br>
電話の通話記録を見ることが出来ます。<br><br>
管理者画面<br>
サーバーにある電話関係の設定ファイルを更新する事ができます。<br>
※管理者ユーザ・パスワードの入力が必要です。<br>
</div>
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
Asteriskとは？<br>
AsteriskはオープンソースのPBXです。<br>
簡単に言うと、コンピュータ１つで電話交換機が作れてしまいます。<br><br>
DigiumのMark Spencerによって始められました。(主に)Linuxプラットフォーム上で動作します。<br><br>
PBXというと会社内の電話やビジネスホン等を思い浮かべるのですが、Asteriskが使用されるのは、いわゆる電話の分野だけではありません。<br><br>
通話を繋いだり切ったり(呼制御)、通話を必要とするサービスは旧来の電話だけで使われるわけではありません。様々な音声サービスに使用できるのがAsteriskです。<br><br>
このため電話交換機からインターネット上の音声サービスまで様々に使用されているのがAsteriskです。<br><br>
日本でAsteriskが広く知られるようになったのは2005年頃からです。
<br><br>
本システムで出来る事<br>
☆一般ユーザ<br>
〇新しい電話機の台帳管理<br>
〇呼情報（どの電話がどのくらい使用されたかの情報）の確認<br><br>
☆管理者ユーザ<br>
〇システムアップデート情報の管理<br>
〇asteriskサーバの設定変更<br>
</div>
  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
  <?php echo $sys_data; ?>
</div>
</div>
</div>
