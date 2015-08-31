<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Hitu-online</title>
    <link rel="stylesheet" href="views/assets/css/bootstrap.min.css">
    <link rel="icon" href="views/assets/img/hitu.png">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="views/assets/js/bootstrap.min.js"></script>

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
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="#" class="navbar-brand">Hitu-online</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">基本信息</a></li>
                    <li><a href="#">通讯录</a></li>
                    <li><a href="#">行程管理</a></li>
                    <li><a href="#">数据统计</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">个人资料<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">修改密码</a></li>
                            <li><a href="#">意见反馈</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">退出登录</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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
</body>
</html>