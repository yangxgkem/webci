//登录失败模态提示
function show_message(title, data)
{
    if (title && title.length > 0)
    {
        login_fail_title.innerHTML = title;
    }
    if (data && data.length > 0)
    {
        login_fail_msg.innerHTML = data;
    }
    $("#login_fail_modal").modal();
}

//点击按钮登录
function login()
{
    var id = $("#id");
    var pw = $("#pw");

    if (!id.val() || id.val().length < 1)
    {
        show_message(null, "账号不能为空");
        return;
    }
    if ( ! pw.val() || pw.val().length < 1)
    {
        show_message(null, "密码不能为空");
        return;
    }

    $.post("login/login",
        {
            id:id.val(),
            pw:pw.val(),
        },
        function(data, status){
            var obj = JSON.parse(data);
            if (obj.errno != 0)
            {
                show_message("登录失败:"+obj.errno, obj.errmsg);
                return;
            }
            self.location='main';
        });
}