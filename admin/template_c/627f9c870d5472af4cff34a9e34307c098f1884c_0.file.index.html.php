<?php
/* Smarty version 3.1.30, created on 2020-09-20 20:34:38
  from "D:\phpStudy\PHPTutorial\WWW\kaoshi\admin\template\index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f674c5e154a12_69341163',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '627f9c870d5472af4cff34a9e34307c098f1884c' => 
    array (
      0 => 'D:\\phpStudy\\PHPTutorial\\WWW\\kaoshi\\admin\\template\\index.html',
      1 => 1598950237,
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
function content_5f674c5e154a12_69341163 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:admin_header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>"后台-考试系统"), 0, false);
?>


<?php $_smarty_tpl->_subTemplateRender("file:admin_top.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div id="page-wrapper" class="gray-bg dashbard-1">
    <div class="text-center">
    	<h1>欢迎您,Admin</h1>
    </div>
</div>

<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

</body>

</html><?php }
}
