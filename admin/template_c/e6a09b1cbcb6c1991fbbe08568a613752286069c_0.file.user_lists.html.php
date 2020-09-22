<?php
/* Smarty version 3.1.30, created on 2020-09-20 20:54:31
  from "D:\phpStudy\PHPTutorial\WWW\kaoshi\admin\template\user_lists.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6751073f5b39_95520790',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e6a09b1cbcb6c1991fbbe08568a613752286069c' => 
    array (
      0 => 'D:\\phpStudy\\PHPTutorial\\WWW\\kaoshi\\admin\\template\\user_lists.html',
      1 => 1600367892,
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
function content_5f6751073f5b39_95520790 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:admin_header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>"后台-考试系统"), 0, false);
?>

<style>
	a.cur{
		color: #23527c!important;
	    background-color: #eee!important;
	    border-color: #ddd!important;
    }
</style>
<?php $_smarty_tpl->_subTemplateRender("file:admin_top.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div class="container-fluid">
	<div class="row-fluid">
		<div class="main">
			<div class="col-xs-2 leftmenu">
				<ul class="list-group">
					<li class="list-group-item active">
						<a href="?ctl=user&act=studentLists">学员管理</a>
					</li>
					<li class="list-group-item">
						<a href="?ctl=user&act=teacherLists">教师管理</a>
					</li>
					<li class="list-group-item">
						<a href="?ctl=user&act=adminLists">管理员管理</a>
					</li>
				</ul>
			</div>

			<div id="datacontent">
				<div class="box itembox" style="margin-bottom:0px;border-bottom:1px solid #CCCCCC;">
					<div class="col-xs-12">
						<ol class="breadcrumb">
							<li><a href="#">用户管理</a></li>
							<li class="active">学员管理</li>
						</ol>
					</div>
				</div>

				<div class="box itembox" style="padding-top:10px;margin-bottom:0px;">
					<h4 class="title" style="padding:10px;">
						学员列表
						<span class="pull-right">
							<a data-toggle="dropdown" class="btn btn-primary dropdown-toggle" href="#">添加学员&nbsp;<strong class="caret"></strong></a>
							<ul class="dropdown-menu">
								<li><a href="?ctl=user&act=addStudentPage">单个学员</a></li>
								<li><a href="?ctl=user&act=batAddStudentPage">从excel文件导入</a></li>
							</ul>
						</span>
					</h4>
					<table class="table table-hover table-bordered">
						<thead>
							<tr class="info">
								<th>ID</th>
								<th>姓名</th>
								<th>性别</th>
								<th>学号/身份证</th>
								<th>学校</th>
								<th>专业</th>
								<th>年级</th>
								<th>科目</th>
								<th>最后登录时间</th>
								<th width="100">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['row']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
							<tr>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
								<td><?php if ($_smarty_tpl->tpl_vars['v']->value['sex'] == 'm') {?>男<?php } else { ?>女<?php }?></td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['student_id'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['school'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['majors'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['grade'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['course'];?>
</td>
								<td><?php if ($_smarty_tpl->tpl_vars['v']->value['last_login'] == '') {?>暂未登录<?php } else {
echo $_smarty_tpl->tpl_vars['v']->value['last_login'];
}?></td>
								<td>
									<div class="btn-group">
										<a class="btn" href="?ctl=user&act=editStudentPage&uid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" title="编辑资料"><em class="glyphicon glyphicon-edit"></em></a>
										<a class="btn  delconfirm" data-uid="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" data-gourl="?ctl=user&act=studentLists"><em class="glyphicon glyphicon-remove"></em></a>
									</div>
								</td>
							</tr>
							<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

						</tbody>
					</table>
				</div>
			</div>
			<ul class="pagination" style="text-align: center;display: block;">
				<?php echo $_smarty_tpl->tpl_vars['showpage']->value;?>

			</ul>
		</div>
	</div>
</div>

<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
 src="https://cdn.bootcdn.net/ajax/libs/bootstrap-confirmation/1.0.7/bootstrap-confirmation.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
> 
$(function () { 
	$('.delconfirm').confirmation({

		animation: true, 
		placement: "top", 
		title: "确定要删除吗？", 
		btnOkLabel: '确定', 
		btnCancelLabel: '取消', 
		onConfirm: function () { 
			console.log(this.options.uid); 
			var uid = this.options.uid;
			var gourl = this.options.gourl;

			$.post("/index.php?ctl=user&act=delStudent", { uid:uid,gourl:gourl },
			function(data){
				console.log(data);
		    	window.location.href=data.gourl;
			}, "json");
			
		}, 
		onCancel: function () { 
			//alert("点击了取消"); 
		} 
	}) 
});
<?php echo '</script'; ?>
> 
</body>

</html><?php }
}
