<h2>创建新闻</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('news/create') ?>

	<label for="title">新闻标题</label>
	<input type="input" name="title" /><br/><br/>

	<label for="text">新闻内容</label>
	<textarea name="text"></textarea><br/><br/>

	<input type="submit" name="submit" value="提交" /><br/>

</form>

<p><a href="http://192.168.8.128/index.php/news">返回上一层</a></p>