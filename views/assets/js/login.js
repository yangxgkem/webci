document.write("<script src='/assets/js/base.js' type='text/javascript'></script>");

//点击按钮登录
function login() {
    var id = $("#id");
    var pw = $("#pw");

    if (!id.val() || id.val().length < 1) {
        show_model(null, "账号不能为空");
        return;
    }
    if ( ! pw.val() || pw.val().length < 1) {
        show_model(null, "密码不能为空");
        return;
    }

    var post_data = {
        "pname":"c2s_login_login",
        "id":id.val(),
        "pw":pw.val(),
    };

    function post_func(data, status) {
        var obj = JSON.parse(data);
        if (obj.errno != 0) {
            show_model("登录失败:"+obj.errno, obj.errmsg);
            return;
        }
        setCookie("userid", id.val());
        self.location='/pc/baseinfo';
    }

    post_server(post_data, post_func);

    return false;
}