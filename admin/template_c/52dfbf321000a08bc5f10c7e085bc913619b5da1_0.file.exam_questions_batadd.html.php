<?php
/* Smarty version 3.1.30, created on 2020-09-20 20:54:37
  from "D:\phpStudy\PHPTutorial\WWW\kaoshi\admin\template\exam_questions_batadd.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f67510d04a101_39642869',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '52dfbf321000a08bc5f10c7e085bc913619b5da1' => 
    array (
      0 => 'D:\\phpStudy\\PHPTutorial\\WWW\\kaoshi\\admin\\template\\exam_questions_batadd.html',
      1 => 1600160500,
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
function content_5f67510d04a101_39642869 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:admin_header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>"创建试题-考试系统"), 0, false);
?>

<style>
	
</style>
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
							<li class="active">创建试题</li>
						</ol>
					</div>
				</div>
								<div class="box itembox" style="padding-top:10px;margin-bottom:0px;">
					<h4 class="title" style="padding:10px;">
						批量创建试题
						<a class="pull-right btn btn-primary" href="?ctl=exam&act=examLists">试卷列表</a>
					</h4>
					<form  class="form-horizontal" id="bataddStudent">
						<fieldset>
							<div class="form-group">
								<label for="username" class="control-label col-sm-2">示范格式</label>
								<div class="col-sm-9">
									<img src="/images/pc/exam.png" style="width:100%;">
								</div>
							</div>
							<div class="form-group">
								<label for="lesson_video" class="control-label col-sm-2">待导入文件</label>
								<div class="col-sm-10 form-inline">
						            <ul class="list-unstyled pull-left" style="clear:both;">
						                <li class="text-center">
						                     <input type="file"  name="fileToUpload" id="fileToUpload">
						                </li>
						            </ul>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2"></label>
								<div class="col-sm-10">
									<button class="btn btn-primary bataddStudent" data-id=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
>导入</button>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $_smarty_tpl->_subTemplateRender("file:admin_footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
 src="/admin/js/ajaxfileupload.js"><?php echo '</script'; ?>
>
</body>
<?php echo '<script'; ?>
>
	$('.bataddStudent').click(function(e){
		e.preventDefault();//禁止冒泡
		//console.log(e);
		var id = e.currentTarget.dataset.id;
		var file = $('#fileToUpload').val();
		if (id == '') {
			dtAlert({ message:'数据错误',title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
			return false;
		}
		if (file == '') {
			dtAlert({ message:'请选择文件上传',title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
			return false;
		}
		var filename = file.replace(/.*(\/|\\)/, '');
　　　　	var point = filename.lastIndexOf(".");  
 		var fileext = filename.substr(point);  
		// if (fileext != '.xlsx' || fileext != '.xls' || fileext != '.csv') {
		// 	dtAlert({ message:'请上传正确的文件格式',title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
		// 	return false;
		// }

		$.ajaxFileUpload({
            url: "/index.php?ctl=exam&act=batCreatExamQuestion&id="+id,
            secureuri: false,
            fileElementId: 'fileToUpload',
            async: false,
            dataType: 'content',
            success: function (result) {
                console.log(result);
                if(result.res == 'failed'){
                	dtAlert({ message:result.msg,title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
					return false;
                }else{
                	dtAlert({ message:'导入成功!',title:'<i class="glyphicon glyphicon-ok"></i>',style:'primary',callback:"window.location.href='?ctl=exam&act=examLists';" });
                }
            }
        });
	})
<?php echo '</script'; ?>
>
</html><?php }
}
