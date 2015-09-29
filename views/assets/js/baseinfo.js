document.write("<script src='/assets/js/base.js' type='text/javascript'></script>");

//显示结果
function show_baseinfo(data) {
    var obj = JSON.parse(data);
    document.getElementById("name").value = obj.name;
    document.getElementById("phone").value = obj.phone;
    if(obj.sex==1) {
        document.getElementById("boy").checked = true;
    }
    else {
        document.getElementById("girl").checked = true;
    }
    document.getElementById("wechat").value = obj.wechat;
    document.getElementById("guide_id").value = obj.guide_id;
    document.getElementById("email").value = obj.email;
    document.getElementById("sign").value = obj.sign;
}

//加载模块调用
$(document).ready(function() {
    var post_data = {
        "pname":"c2s_guide_info",
        "id":getCookie("userid"),
    };
    //console.log(post_data);

    function post_func(data, status) {
        show_baseinfo(data);
    }

    post_server(post_data, post_func);
});

//更新数据
function updateinfo() {
    var sex = 1;
    if(document.getElementById("girl").checked==true) {
        sex = 0;
    }

    var post_data = {
        "pname":"c2s_guide_update",
        "name":document.getElementById("name").value,
        "sex":sex,
        "sign":document.getElementById("sign").value,
    };

    function post_func(data, status) {
        var obj = JSON.parse(data);
        if(obj.errno == 0) {
            show_model("更新", "更新成功");
        }
    }

    post_server(post_data, post_func);
}