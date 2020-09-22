<?php
/* Smarty version 3.1.30, created on 2020-09-21 04:54:20
  from "D:\phpStudy\PHPTutorial\WWW\kaoshi\admin\template\exam_category.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f67c17cb17cb8_57755617',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a885a242102860c8f1421b98cbb00f7f9aeb2dd4' => 
    array (
      0 => 'D:\\phpStudy\\PHPTutorial\\WWW\\kaoshi\\admin\\template\\exam_category.html',
      1 => 1600156861,
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
function content_5f67c17cb17cb8_57755617 (Smarty_Internal_Template $_smarty_tpl) {
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
						<a href="?ctl=exam&act=examCategoryPage">试卷分类</a>
					</li>
					<li class="list-group-item">
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
							<li><a href="#">试卷管理</a></li>
							<li class="active">试卷分类</li>
						</ol>
					</div>
				</div>

				<div class="box itembox" style="padding-top:10px;margin-bottom:0px;">
					<h4 class="title" style="padding:10px;">
						试卷分类
						<span class="pull-right">
							<a class="btn btn-primary" href="?ctl=exam&act=AddExamCategoryPage">添加分类</a>
						</span>
					</h4>
					<table class="table table-hover table-bordered">
						<thead>
							<tr class="info">
								<th>ID</th>
								<th>学校</th>
								<th>专业</th>
								<th>年级</th>
								<th>学期</th>
								<th>科目</th>
								<th width="200">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['row']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
							<tr>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['school'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['majors'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['grade'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['term'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['course'];?>
</td>
								<td>
									<div class="btn-group">
										<a class="btn" href="?ctl=exam&act=creatExamForCPage&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"  title="添加试卷"><em class="glyphicon glyphicon-plus-sign"></em></a>
										<a class="btn" href="?ctl=exam&act=editExamCategoryPage&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" title="编辑分类"><em class="glyphicon glyphicon-edit"></em></a>
										<!-- <a class="btn  delconfirm" data-id="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" data-gourl="<?php echo $_SERVER['REQUEST_URI'];?>
"><em class="glyphicon glyphicon-remove"></em></a> -->
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
			console.log(this.options.id); 
			var id = this.options.id;
			var gourl = this.options.gourl;

			$.post("/index.php?ctl=exam&act=delExamCategory", { id:id,gourl:gourl },
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
