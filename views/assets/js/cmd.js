document.write("<script src='/views/assets/js/base.js' type='text/javascript'></script>");

//打印结果
function show_message(data) {
    document.getElementById("retsult").value = data;
}

//加载模块调用
$(document).ready(function() {

});

//提交指令
function cmd() {
    var protomsg = $("#protomsg");

    if (!protomsg.val() || protomsg.val().length < 1) {
        show_model("错误", "指令不能为空");
        return;
    }

    var post_data = {
        "pname":"c2s_cmd_cmd",
        "command":protomsg.val(),
    };
    function post_func(data, status) {
        show_message(data);
    }
    post_server(post_data, post_func);
}

//查看当前session
function get_session() {
    var post_data = {
        "pname":"c2s_cmd_cmd",
        "command":"/protomsg 101",
    };
    function post_func(data, status) {
        show_message(data);
    }
    post_server(post_data, post_func);
}