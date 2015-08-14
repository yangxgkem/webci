<!DOCTYPE html>
<html>
  <head lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>登录</title>

    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">

    <!-- No Baidu Siteapp-->
    <meta http-equiv="Cache-Control" content="no-siteapp"/>

    <link rel="stylesheet" href="application/views/assets/css/amazeui.min.css" />
    <style>
      .header {
        text-align: center;
      }
      .header h1 {
        font-size: 200%;
        color: #333;
        margin-top: 30px;
      }
      .header p {
        font-size: 14px;
      }
    </style>
  </head>
<body>
<div class="header">
  <div class="am-g">
    <h1>LOGIN</h1>
    <p>好导游登录界面</p>
  </div>
</div>
<br/>
<br/>
<div class="am-g am-g-fixed">
  <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
    <form method="post" class="am-form" action="<?php echo $action ?>">
      <div class="am-input-group">
        <span class="am-input-group-label"><i class="am-icon-user am-icon-fw"></i></span>
        <input type="email" class="am-form-field" name="account" placeholder="Username">
      </div>
      <br/>
      <div class="am-input-group">
        <span class="am-input-group-label"><i class="am-icon-lock am-icon-fw"></i></span>
        <input type="password" class="am-form-field" name="password" placeholder="Password">
      </div>
      <br/>
      <div class="am-cf">
        <input type="submit" name="" value="登 录" class="am-btn am-btn-primary am-btn-sm am-fl">
        <input type="submit" name="" value="忘记密码 ^_^? " class="am-btn am-btn-default am-btn-sm am-fr">
      </div>
    </form>
  </div>
</div>
<hr>
<footer>
  <div class="am-g">
    <p>© 2015</p>
  </div>
</footer>
</body>
</html>