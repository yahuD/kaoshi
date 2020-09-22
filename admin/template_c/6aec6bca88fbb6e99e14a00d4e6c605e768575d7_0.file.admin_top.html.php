<?php
/* Smarty version 3.1.30, created on 2020-09-20 20:02:02
  from "D:\phpStudy\PHPTutorial\WWW\kaoshi\admin\template\admin_top.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6744ba4d5bd2_63187746',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6aec6bca88fbb6e99e14a00d4e6c605e768575d7' => 
    array (
      0 => 'D:\\phpStudy\\PHPTutorial\\WWW\\kaoshi\\admin\\template\\admin_top.html',
      1 => 1600096261,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6744ba4d5bd2_63187746 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="container-fluid navbar" style="margin-top:0px;margin-bottom:0px;background-color:#337AB7;">
	<div class="row-fluid">
		<div class="main">
			<div class="col-xs-12">
				<ul class="list-unstyled list-inline">
					<li>
						<span class="logo">科普教育</span>
					</li>
					<!-- <li class="menu  <?php if ($_SERVER['REQUEST_URI'] == '/index.php?ctl=registerLogin&act=adminindex') {?>active<?php }?>"> -->
					<li class="menu <?php if ($_smarty_tpl->tpl_vars['show']->value == 'index') {?>active<?php }?>">
						<a href="?ctl=registerLogin&act=adminindex">首页</a>
					</li>
					<!-- <li class="menu <?php if ($_SERVER['REQUEST_URI'] == '/index.php?ctl=user&act=studentLists') {?>active<?php }?>"> -->

					<li class="menu <?php if ($_smarty_tpl->tpl_vars['show']->value == 'user') {?>active<?php }?>">
						<a href="?ctl=user&act=studentLists">用户管理</a>
					</li>
					<li class="menu <?php if ($_smarty_tpl->tpl_vars['show']->value == 'exam') {?>active<?php }?>">
						<a href="?ctl=exam&act=examLists">试卷管理</a>
					</li>
					<li class="menu <?php if ($_smarty_tpl->tpl_vars['show']->value == 'test') {?>active<?php }?>">
						<a href="?ctl=exam&act=examTest">考试管理</a>
					</li>

					<li class="pull-right">
						<div class="btn-group" style="margin-top: 15px;">
							<button type="button" class="btn btn-info"><em class="glyphicon glyphicon-user"></em> admin</button>
							<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<ul class="dropdown-menu">
								<!-- <li><a href="index.php?user-center"><em class="glyphicon glyphicon-user"></em> 用户中心</a></li>
                                <li><a href="index.php?core-master"><em class="glyphicon glyphicon-dashboard"></em> 后台管理</a></li> -->
                                <li><a class="ajax" href="/index.php?ctl=registerLogin&act=adminLogout"><em class="glyphicon glyphicon-log-out"></em> 退出</a></li>
							</ul>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div><?php }
}
