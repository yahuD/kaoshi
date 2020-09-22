<?php
/* Smarty version 3.1.30, created on 2020-09-20 20:02:06
  from "D:\phpStudy\PHPTutorial\WWW\kaoshi\admin\template\student_grade.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6744be12f722_89789013',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e6be82187852891dd8466a5a1e8c245daf7eeb37' => 
    array (
      0 => 'D:\\phpStudy\\PHPTutorial\\WWW\\kaoshi\\admin\\template\\student_grade.html',
      1 => 1600505123,
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
function content_5f6744be12f722_89789013 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:admin_header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>"后台-考试系统"), 0, false);
?>

<link rel="stylesheet" type="text/css" href="/admin/css/student_grade.css" />
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
							<li>考试管理</li>
							<li class="active">考试成绩</li>
						</ol>
					</div>
				</div>

				<!-- <div class="box itembox" style="margin-bottom:0px;border-bottom:1px solid #CCCCCC;">
					<div class="col-xs-12">
						<ol class="breadcrumb">
							<li>考试名称</li>
							<li>考试管理</li>
							<li class="active">考试成绩</li>
						</ol>
					</div>
				</div> -->
				<div class="smain">
					<div class="test_top">
						<div class="item">考试名称</div>
						<div class="item">考试类型</div>
						<div class="item">考试时间</div>		
					</div>
					<div class="test_bottom">
						<div class="item"><?php echo $_smarty_tpl->tpl_vars['test']->value['title'];?>
</div>
						<div class="item"><?php echo $_smarty_tpl->tpl_vars['test']->value['section'];?>
</div>
						<div class="item"><?php echo $_smarty_tpl->tpl_vars['test']->value['begin_time'];?>
~<?php echo $_smarty_tpl->tpl_vars['test']->value['end_time'];?>
</div>		
					</div>
					<input type="hidden" id="test_num" value="<?php echo $_smarty_tpl->tpl_vars['test']->value['id'];?>
">
					
				</div>

				<div class="box itembox" style="padding-top:10px;margin-bottom:0px;">
					<h4 class="title" style="padding:10px;">
						成绩列表
					</h4>
					<table class="table table-hover table-bordered">
						<thead>
							<tr class="info">
								<th><input type="checkbox" name="all" id="check_all"></th>
								<th>学号</th>
								<th>姓名</th>
								<th>所属专业</th>
								<th>分数</th>
								<th>及格</th>
								<th>是否为补考</th>
								<th>强制交卷</th>
								<th>交卷时间</th>
								<th>您的判分进度</th>
								<th width="150">操作</th>
							</tr>
						</thead>
						<tbody id="tb">
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
								<tr>
									<td><input type="checkbox" name="" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" class="item_check"></td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['student_id'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['student_name'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['student_majors'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['score'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['is_jige'];?>
</td>
									<td>否</td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['is_qiangzhi'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['create_time'];?>
</td>
									<td><?php echo $_smarty_tpl->tpl_vars['v']->value['is_reviewe'];?>
</td>
									<td>
										<div class="btn-group">
											<a class="btn" href="?ctl=exam&act=piyue&id=<?php echo $_smarty_tpl->tpl_vars['test']->value['id'];?>
&uid=<?php echo $_smarty_tpl->tpl_vars['v']->value['uid'];?>
" title="阅卷"><em class="glyphicon glyphicon-edit"></em></a>

											<a class="btn" href="?ctl=exam&act=seeStudentGrade&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" title="导出试卷"><em class="glyphicon glyphicon-export"></em></a>
											<a class="btn" href="?ctl=exam&act=seeStudentGrade&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" title="删除试卷"><em class="glyphicon glyphicon-remove"></em></a>
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
					<div class="jiluBtn">
						<span>共有<?php echo $_smarty_tpl->tpl_vars['list_count']->value;?>
记录</span>
						<button class="del_btn">批量删除</button>
						<button class="daochu_btn">批量导出</button>
						
					</div>
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
 crossorigin="anonymous" integrity="sha384-rY/jv8mMhqDabXSo+UCggqKtdmBfd3qC2/KvyTDNQ6PcUJXaxK1tMepoQda4g5vB" src="https://lib.baomitu.com/jquery/2.2.4/jquery.min.js"><?php echo '</script'; ?>
>
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
<?php echo '<script'; ?>
>
	$('#check_all').change(function(){
		if($(this).attr('checked',true)){
			$('.item_check').attr('checked',true)
		}else{
			$('.item_check').attr('checked',false)
		}
	})
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
	$(function(){
		  var idarr =[];

		$('.del_btn').click(function(){
			var test_num = $("#test_num").val();
            $.each($('input:checkbox:checked'),function(){
            	
               var id = $(this).attr("value");
               if(id>0){               
                    idarr.push(id);
                }
            });
            var str = idarr.join(',');
           $.ajax({
           	   url:'/?ctl=exam&act=delAll ',
           	   type:'get',
           	   data:{
           	   	 uid:str,
           	   	 test_num:test_num
           	   },
           	   success:function(data){
           	   	var obj = new Function("return" + data)();
           	      if(obj.res == 'failed'){
           	      	alert(obj.msg);
           	      	location.reload();
           	      }else{
           	      	alert(obj.msg);
           	      }
           	   
           	   }
           })

		})
         //导出
         	$('.daochu_btn').click(function(){
			var test_num = $("#test_num").val();
            $.each($('input:checkbox:checked'),function(){
            	
               var id = $(this).attr("value");
               if(id>0){               
                    idarr.push(id);
                }
            });
            var str = idarr.join(',');
            window.location.href = "/?ctl=exam&act=export&uid="+str+"&test_num="+test_num;
           // $.ajax({
           // 	   url:'/?ctl=exam&act=export ',
           // 	   type:'get',
           // 	   data:{
           // 	   	 uid:str,
           // 	   	 test_num:test_num
           // 	   },
           // 	   success:function(data){
           // 	   	console.log(111);
           	
           // 	   }
           // })

		})
	})
<?php echo '</script'; ?>
>
</body>

</html><?php }
}
