<?php
/* Smarty version 3.1.30, created on 2020-09-20 20:34:11
  from "D:\phpStudy\PHPTutorial\WWW\kaoshi\admin\template\add_exam_test.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f674c4354fef1_59848204',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd6bdc757dbf00cd3d94db00155b916aa63b598eb' => 
    array (
      0 => 'D:\\phpStudy\\PHPTutorial\\WWW\\kaoshi\\admin\\template\\add_exam_test.html',
      1 => 1600096420,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_header.html' => 1,
    'file:admin_top.html' => 1,
    'file:admin_footer.html' => 1,
  ),
),false)) {
function content_5f674c4354fef1_59848204 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:admin_header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>"发布考试-考试系统"), 0, false);
?>


<?php $_smarty_tpl->_subTemplateRender("file:admin_top.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div class="container-fluid">
	<div class="row-fluid">
		<div class="main">
			<div class="col-xs-2 leftmenu">
				<ul class="list-group">
					<li class="list-group-item active">
						<a href="?ctl=exam&act=examTest">考试管理</a>
					</li>
				</ul>
			</div>

			<div id="datacontent">
				<div class="box itembox" style="margin-bottom:0px;border-bottom:1px solid #CCCCCC;">
					<div class="col-xs-12">
						<ol class="breadcrumb">
							<li>考试</li>
							<li><a href="/exam/test">考试管理</a></li>
							<li class="active">发布考试</li>
						</ol>
					</div>
				</div>

				<div class="box itembox" style="padding-top:10px;margin-bottom:0px;">
					<h4 class="title" style="padding:10px;">
						发布考试
						<a class="pull-right btn btn-primary" href="?ctl=exam&act=examTest">考试管理</a>
					</h4>
					<form class="form-horizontal" id="addexam" style="margin-top:40px;">
						<div class="form-group">
							<label for="password2" class="control-label col-sm-2">考试名称</label>
							<div class="col-sm-4">
								<input class="form-control" type="text" id="title" equ="title" needle="needle" datatype="title" msg="请输入考试名称" name="title"/>
								<span class="help-block">请输入考试名称</span>
							</div>
						</div>
						<div class="form-group">
							<label for="password2" class="control-label col-sm-2">考试所属分类</label>
							<div class="col-sm-4">
								<select name='category' id="category" class="form-control" style="margin-top: 10px;">
									<option value="0">请选择</option>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['section']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['school'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['majors'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['grade'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['term'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['course'];?>
</option>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="password2" class="control-label col-sm-2">选择试卷</label>
							<div class="col-sm-4">
								<select name='exam' id="exam" class="form-control" style="margin-top: 10px;">
									<option value="0">请选择</option>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['exampaper']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</option>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label for="password2" class="control-label col-sm-2">考试开始时间</label>
							<div class="col-sm-4">
								<input class="form-control" type="datetime-local" id="begain_time" equ="begain_time" needle="begain_time" datatype="begain_time" msg="考试开始时间" name="begain_time"/>
								<span class="help-block">考试开始时间</span>
							</div>
						</div>

						<div class="form-group">
							<label for="password2" class="control-label col-sm-2">考试结束时间</label>
							<div class="col-sm-4">
								<input class="form-control" type="datetime-local" id="end_time" equ="end_time" needle="end_time" datatype="end_time" msg="考试结束时间" name="end_time"/>
								<span class="help-block">考试结束时间</span>
							</div>
						</div>

						<div class="form-group">
							<label for="password2" class="control-label col-sm-2">选择批卷老师</label>
							<div class="col-sm-4">
								<select name='grader' id="grader" class="form-control" style="margin-top: 10px;">
									<option value="0">请选择</option>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['teacher']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="password2" class="control-label col-sm-2">是否补考</label>
							<div class="col-sm-4">
								<div class="radio">
									<label>
										<input type="radio" name="is_make_up"  value="0" checked>
									否
									</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio" name="is_make_up" value="1">
									是
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="groupid" class="control-label col-sm-2"></label>
							<div class="col-sm-4">
								<button class="btn btn-primary addexam">发布</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


</body>
<?php echo '<script'; ?>
>
	$('.addexam').click(function(e){
		e.preventDefault();//禁止冒泡
		var title = $('#title').val();
		var category = $('#category').val();
		var exam = $('#exam').val();
		var begain_time = $('#begain_time').val();
		var begain_time = $('#begain_time').val();
		var grader = $('#grader').val();

		if(title == ''){
			dtAlert({ message:'请输入考试名称',title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
			return false;
		}
		if(category == 0){
			dtAlert({ message:'请选择考试分类',title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
			return false;
		}
		if(grader == 0){
			dtAlert({ message:'请选择阅卷老师',title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
			return false;
		}
		if(exam == 0){
			dtAlert({ message:'请选择试卷',title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
			return false;
		}
		if(begain_time == ''){
			dtAlert({ message:'请输入考试开始时间',title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
			return false;
		}
		if(end_time == ''){
			dtAlert({ message:'请输入考试结束时间',title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
			return false;
		}

		$.post("/index.php?ctl=exam&act=addExamTest", $('#addexam').serialize(),
			function(data){
				console.log(data);
		    	if(data.res == 'failed'){
		    		dtAlert({ message:data.msg,title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
					return false;
		    	}else{
		    		dtAlert({ message:'发布成功',title:'<i class="glyphicon glyphicon-ok"></i>',style:'primary',callback:"window.location.href='?ctl=exam&act=examTest';" });
		    	}
		}, "json");
	})

<?php echo '</script'; ?>
>
</html><?php }
}
