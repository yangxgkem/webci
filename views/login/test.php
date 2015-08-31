<html>
<head>
	<title>测试</title>
</head>
<body>
	<h1> 测试头部 </h1>
	
	<select>
		<option value="type">请选择风格</option>
		<option value="blue">蓝色</option>
		<option value="green">绿色</option>
	</select>
	
	<br/>
	<br/>

	<table border="1">
		<tr>
			<th>编号</th>
			<th>标题</th>
			<th>时间</th>
		</tr>
		<tr>
			<td>B1</td>
			<td>B2</td>
			<td>B3</td>
		</tr>
		<tr>
			<td>B1</td>
			<td>B2</td>
			<td>B3</td>
		</tr>
	</table>

	<br/>
	<br/>
	
	<form action="test.php" name="userForm" onsubmit="return submitForm();">
      <input id="user" name="user"/>
      <input type="submit" value="提交" />
    </form>

    <br/>
	<br/>

	<div id="mydiv" style="display:block;">
		玩家网社区
	</div>
	<input type="button" value="点击隐藏" onclick="return hide()"/>
	<input type="button" value="点击修改数据" onclick="return set()"/>

	<br/>
	<br/>
	<strong>&copy;2015</strong>
</body>
</html>


<script type="text/javascript" language="JavaScript">
	function submitForm(){
		if(userForm.user.value=="")
		{
			alert("请输入内容"); 
			userForm.user.focus(); 
			return false; 
		}
	}

	function hide() {
        if(document.getElementById("mydiv").style.display != "block")
        {
            document.getElementById("mydiv").style.display = "block";
        }
        else
        {
            document.getElementById("mydiv").style.display = "none";
        }
	}

	function set() {
        if(mydiv.innerHTML !='aaaaaaaaa')
        {
        	alert("aaaa"); 
        	mydiv.innerHTML='aaaaaaaaa';
        }
        else
        {
        	alert("bbbbb"); 
        	mydiv.innerHTML='玩家网社区';
        }
	}
</script>