<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>hitu</title>

    <!-- Bootstrap -->
    <link href="views/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #eee;
      }
      .form-signin {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
      }
    </style>
  </head>

  <body>
    <div class="container">
      <a href="#">
        <img class="center-block" src="views/assets/img/logo-white.png" />
      </a>
    </div>
    <br/>

    <div class="container">
      <form class="form-signin" action="login/login" method="post">
        <div class="form-group">
          <input name="id" type="text" id="inputEmail" class="form-control" placeholder="输入您的手机或导游证" required="" autofocus="">
        </div>
        <div class="form-group">
          <input name="pw" type="password" id="inputPassword" class="form-control" placeholder="输入您的密码" required="">
        </div>
        <div class="text-right">
          <u><a href="#">忘记密码?</a></u>
        </div>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> 记住我
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
      </form>
    </div>

     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="views/assets/js/bootstrap.min.js"></script>

  </body>
</html>