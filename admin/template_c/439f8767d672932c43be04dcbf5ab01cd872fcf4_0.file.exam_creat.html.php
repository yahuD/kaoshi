<?php
/* Smarty version 3.1.30, created on 2020-09-20 20:33:54
  from "D:\phpStudy\PHPTutorial\WWW\kaoshi\admin\template\exam_creat.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f674c32ca3200_72785465',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '439f8767d672932c43be04dcbf5ab01cd872fcf4' => 
    array (
      0 => 'D:\\phpStudy\\PHPTutorial\\WWW\\kaoshi\\admin\\template\\exam_creat.html',
      1 => 1600157269,
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
function content_5f674c32ca3200_72785465 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:admin_header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>"创建试卷-考试系统"), 0, false);
?>


<?php $_smarty_tpl->_subTemplateRender("file:admin_top.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div class="container-fluid">
	<div class="row-fluid">
		<div class="main">
			<div class="col-xs-2 leftmenu">
				<ul class="list-group">
					<li class="list-group-item">
						<a href="?ctl=exam&act=examCategoryPage">试卷分类</a>
					</li>
					<li class="list-group-item active">
						<a href="?ctl=exam&act=examLists">试卷列表</a>
					</li>
					<li class="list-group-item">
						<a href="?ctl=exam&act=examQuestype">题型管理</a>
					</li>
				</ul>
			</div>

			<div id="datacontent">
				<div class="box itembox" style="margin-bottom:0px;border-bottom:1px solid #CCCCCC;">
					<div class="col-xs-12">
						<ol class="breadcrumb">
							<li>试卷管理</li>
							<li><a href="?ctl=exam&act=examLists">试卷列表</a></li>
							<li class="active">创建试卷</li>
						</ol>
					</div>
				</div>

				<div class="box itembox" style="padding-top:10px;margin-bottom:0px;">
					<h4 class="title" style="padding:10px;">
						创建试卷
						<a class="pull-right btn btn-primary" href="?ctl=exam&act=examLists">试卷列表</a>
					</h4>
					<form class="form-horizontal" id="addexam" style="margin-top:40px;">
						<div class="form-group">
							<label for="password2" class="control-label col-sm-2">试卷名称</label>
							<div class="col-sm-4">
								<input class="form-control" type="text" id="title" equ="title" needle="needle" datatype="title" msg="请输入学校" name="title"/>
								<span class="help-block">请试卷名称</span>
							</div>
						</div>
						<div class="form-group">
							<label for="password2" class="control-label col-sm-2">试卷所属分类</label>
							<div class="col-sm-4">
								<select name='category' id="category" class="form-control" style="margin-top: 10px;">
									<option value="0">请选择</option>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['lists']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['id']->value == $_smarty_tpl->tpl_vars['v']->value['id']) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['school'];?>
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
							<label  class="control-label col-sm-2">试卷状态</label>
							<div class="col-sm-4">
								<select name='status' id="status" class="form-control" style="margin-top: 10px;">
									<option value="0">请选择</option>
									<option value="1" selected="selected">启用</option>
									<option value="2">停用</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="password2" class="control-label col-sm-2">及格线</label>
							<div class="col-sm-4">
								<input class="form-control" type="number" id="pass_line" equ="pass_line" needle="pass_line" datatype="pass_line" msg="请输入及格线" name="pass_line"/>
								<span class="help-block">请输入及格线</span>
							</div>
						</div>

						<div class="form-group">
							<label for="groupid" class="control-label col-sm-2"></label>
							<div class="col-sm-4">
								<button class="btn btn-primary addexam">创建</button>
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
		var status = $('#status').val();
		var pass_line = $('#pass_line').val();

		if(title == ''){
			dtAlert({ message:'请输入试卷名称',title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
			return false;
		}
		if(category == 0){
			dtAlert({ message:'请选择试卷分类',title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
			return false;
		}
		if(status == 0){
			dtAlert({ message:'请选择试卷状态',title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
			return false;
		}
		if(pass_line == ''){
			dtAlert({ message:'请输入及格线',title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
			return false;
		}

		$.post("/index.php?ctl=exam&act=creatExam", $('#addexam').serialize(),
			function(data){
				console.log(data);
		    	if(data.res == 'failed'){
		    		dtAlert({ message:data.msg,title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
					return false;
		    	}else{
		    		dtAlert({ message:'创建成功',title:'<i class="glyphicon glyphicon-ok"></i>',style:'primary',callback:"window.location.href='?ctl=exam&act=examLists';" });
		    	}
		}, "json");
	})

<?php echo '</script'; ?>
>
</html><?php }
}
