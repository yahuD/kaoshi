<?php
/* Smarty version 3.1.30, created on 2020-09-20 20:34:44
  from "D:\phpStudy\PHPTutorial\WWW\kaoshi\admin\template\exam_questions_add.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f674c647a5862_58023629',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9426097ebaf3e546c93ecc0d4c0f349908113f4e' => 
    array (
      0 => 'D:\\phpStudy\\PHPTutorial\\WWW\\kaoshi\\admin\\template\\exam_questions_add.html',
      1 => 1600351894,
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
function content_5f674c647a5862_58023629 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:admin_header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>"创建试题-考试系统"), 0, false);
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
							<li class="active">创建试题</li>
						</ol>
					</div>
				</div>

				<div class="box itembox" style="padding-top:10px;margin-bottom:0px;">
					<h4 class="title" style="padding:10px;">
						创建试题
						<a class="pull-right btn btn-primary" href="?ctl=exam&act=batCreatExamQuestionPage&id=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
">批量导入试题</a>
					</h4>
					<form class="form-horizontal" id="addquestions" style="margin-top:40px;">
						<div class="form-group">
							<label for="password2" class="control-label col-sm-2">试卷列表</label>
							<div class="col-sm-5">
								<select name='exam' id="exam" class="form-control" style="margin-top: 10px;">
									<option value="0">请选择</option>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['exam']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['id']->value == $_smarty_tpl->tpl_vars['v']->value['id']) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value['school'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['majors'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['grade'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['term'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['course'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
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
							<label  class="control-label col-sm-2">题型</label>
							<div class="col-sm-4">
								<select name='questype' id="questype" class="form-control" style="margin-top: 10px;">
									<option value="0" selected="selected">请选择</option>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['row']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['questype'];?>
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
							<label for="password2" class="control-label col-sm-2">题目</label>
							<div class="col-sm-4">
								<input class="form-control" type="text" id="question" equ="question" needle="question" datatype="question" msg="请输入选项" name="question"/>
								<span class="help-block">请输入题目</span>
							</div>
						</div>

						<div class="form-group option" style="display:none;">
							<label for="password2" class="control-label col-sm-2">选项</label>
							<div class="col-sm-4">
								<input class="form-control" type="text" id="option" equ="option" needle="option" datatype="option" msg="请输入选项" name="option"/>
								<span class="help-block">请输入选项</span>
							</div>
						</div>

						<div class="form-group">
							<label for="password2" class="control-label col-sm-2">答案</label>
							<div class="col-sm-4">
								<input class="form-control" type="text" id="answer" equ="answer" needle="answer" datatype="answer" msg="请输入选项" name="answer"/>
								<span class="help-block">请输入答案</span>
							</div>
						</div>

						<div class="form-group">
							<label for="password2" class="control-label col-sm-2">分值</label>
							<div class="col-sm-4">
								<input class="form-control" type="text" id="score" equ="score" needle="score" datatype="score" msg="请输入选项" name="score"/>
								<span class="help-block">请输入分值</span>
							</div>
						</div>

						<div class="form-group">
							<label for="groupid" class="control-label col-sm-2"></label>
							<div class="col-sm-4">
								<button class="btn btn-primary addquestions">创建</button>
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
	$('#questype').change(function(){
		//alert($(this).children('option:selected').val());
		var id = $(this).children('option:selected').val();
		if(id == 1 || id == 2){
			$('.option').show();
		}else{
			$('.option').hide();
		}
	});


	$('.addquestions').click(function(e){
		e.preventDefault();//禁止冒泡
		var exam = $('#exam').val();
		var questype = $('#questype').val();
		var question = $('#question').val();
		var option = $('#option').val();
		var answer = $('#answer').val();
		var score = $('#score').val();

		if(exam == ''){
			dtAlert({ message:'请选择试卷',title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
			return false;
		}
		if(questype == 0){
			dtAlert({ message:'请选择题型',title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
			return false;
		}
		if(question == ''){
			dtAlert({ message:'请输入题目',title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
			return false;
		}
		if((questype == 1 || questype == 2) && option == ''){
			dtAlert({ message:'请输入选项',title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
			return false;
		}
		if(answer == ''){
			dtAlert({ message:'请输入答案',title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
			return false;
		}
		if(score == ''){
			dtAlert({ message:'请输入分值',title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
			return false;
		}
		$.post("/index.php?ctl=exam&act=creatExamQuestion", $('#addquestions').serialize(),
			function(data){
				console.log(data);
		    	if(data.res == 'failed'){
		    		dtAlert({ message:data.msg,title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
					return false;
		    	}else{
		    		dtAlert({ message:'创建成功',title:'<i class="glyphicon glyphicon-ok"></i>',style:'primary',callback:"location.reload();" });
		    	}
		}, "json");
	})

<?php echo '</script'; ?>
>
</html><?php }
}
