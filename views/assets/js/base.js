//缓存数据
var cache_data=$("div");

//添加缓存数据
function set_cache(key, value) {
  $.data(cache_data, key, value);
}

//获取缓存数据
function get_cache(key) {
  return $.data(cache_data, key);
}

//读取链接get数据
function GetRequest() {
  var url = location.search; //获取url中"?"符后的字串
   var theRequest = new Object();
   if (url.indexOf("?") != -1) {
      var str = url.substr(1);
      strs = str.split("&");
      for(var i = 0; i < strs.length; i ++) {
         theRequest[strs[i].split("=")[0]]=(strs[i].split("=")[1]);
      }
   }
   return theRequest;
}

//模态提示
function show_model(title, data) {
    if (title && title.length > 0) {
        document.getElementById("model_title").innerHTML = title;
    }
    if (data && data.length > 0) {
        document.getElementById("model_data").innerHTML = data;
    }
    $("#show_modal").modal();
}

//写cookies
function setCookie(key, value) {
  var overtime = 1*3600*1000;
  var exp = new Date();
  exp.setTime(exp.getTime() + overtime);
  document.cookie = key + "="+ escape(value) + ";expires=" + exp.toGMTString();
}

//读取cookie数据
function getCookie(key) {
  var arr, reg = new RegExp("(^| )"+key+"=([^;]*)(;|$)");
  if(arr = document.cookie.match(reg)) {
    return unescape(arr[2]);
  }
  else {
    return null;
  }
}

//删除cookie
function delCookie(key) {
  var exp = new Date();
  exp.setTime(exp.getTime() - 1);
  var cval=getCookie(key);
  if(cval != null) {
    document.cookie = key + "="+cval+";expires="+exp.toGMTString();
  }
}

//删除所有cookie
function clearCookie() { 
  var strCookie=document.cookie;
  var arrCookie=strCookie.split("; "); // 将多cookie切割为多个名/值对
  for(var i=0;i <arrCookie.length;i++) { // 遍历cookie数组，处理每个cookie对
    var arr=arrCookie[i].split("=");
    if(arr.length>0) {
      delCookie(arr[0]);
    }
  }
}

//向服务端post请求
//data 数组
//callback(data, status) 回调函数
function post_server(data, callback) {
  $.post("/pc/checkproto", data, callback);
}

//向服务器get请求
//data 数组
//callback(data, status) 回调函数
function get_server(data, callback) {
  $.get("/pc/checkproto", data, callback);
}

//进入cmd界面
function goto_cmd() {
    self.location='/pc/cmd';
}

//进入baseinfo界面
function goto_baseinfo() {
  self.location='/pc/baseinfo';
}

//注销登录
function goto_login() {
  clearCookie();
  self.location='/pc/login';
}

//提交意见
function goto_bug() {
  self.location='/pc/bug';
}



