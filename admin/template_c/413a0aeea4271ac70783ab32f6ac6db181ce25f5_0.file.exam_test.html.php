<?php
/* Smarty version 3.1.30, created on 2020-09-20 20:02:02
  from "D:\phpStudy\PHPTutorial\WWW\kaoshi\admin\template\exam_test.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6744ba4ab860_44365212',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '413a0aeea4271ac70783ab32f6ac6db181ce25f5' => 
    array (
      0 => 'D:\\phpStudy\\PHPTutorial\\WWW\\kaoshi\\admin\\template\\exam_test.html',
      1 => 1600353170,
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
function content_5f6744ba4ab860_44365212 (Smarty_Internal_Template $_smarty_tpl) {
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
						<a href="?ctl=exam&act=examTest">考试管理</a>
					</li>
				</ul>
			</div>

			<div id="datacontent">
				<div class="box itembox" style="margin-bottom:0px;border-bottom:1px solid #CCCCCC;">
					<div class="col-xs-12">
						<ol class="breadcrumb">
							<li><a href="#">考试</a></li>
							<li class="active">考试管理</li>
						</ol>
					</div>
				</div>

				<div class="box itembox" style="padding-top:10px;margin-bottom:0px;">
					<h4 class="title" style="padding:10px;">
						考试列表
						<span class="pull-right">
							<a href="?ctl=exam&act=addExamTestPage" class="btn btn-primary">发布考试</strong></a>
						</span>
					</h4>
					<table class="table table-hover table-bordered">
						<thead>
							<tr class="info">
								<th>ID</th>
								<th>分类</th>
								<th>考试名称</th>
								<th>开始时间</th>
								<th>结束时间</th>
								<th>批卷人</th>
								<th>状态</th>
								<th>是否补考</th>
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
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['school'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['majors'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['grade'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['term'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['course'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['begin_time'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['end_time'];?>
</td>
								<td><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
								<td><?php if ($_smarty_tpl->tpl_vars['v']->value['status'] == 0) {?>暂未开始<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['status'] == 1) {?>正在进行<?php } else { ?>已结束<?php }?></td>
								<td><?php if ($_smarty_tpl->tpl_vars['v']->value['is_make_up'] == 0) {?>否<?php } else { ?>是<?php }?></td>
								<td>
									<div class="btn-group">
										<a class="btn" href="?ctl=exam&act=seeStudentGrade&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" title="查看成绩"><em class="glyphicon glyphicon-eye-open"></em></a>
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
