<?php

/**
 * Displays : 用户模块
 * Author   : xy
 * Date     : 2020-09-01
 */

class userAction extends include_init
{
	public function __construct(){
		parent::__construct();
		header("Content-type:text/html;charset=utf-8");
		if(empty($_SESSION['userdetail'])) {
			Header("Location: /adminLogin");
			return false;
		}
	}

	//后台首页
	public function index(){
		$this->smarty->setTempDir_admin();
		$this->smarty->assign('show','index');
		$this->smarty->display('index.html');
	}

	//学员列表
	public function studentLists(){
		

		$sql = "SELECT count(*) AS num FROM kp_user";
		$num = DatabaseHandler::GetOne($sql);

		$p = isset($_GET['page']) ? intval($_GET['page']) : 1;
 		$pager = new include_page($num,10,$p);
		$showpage=$pager->showpage2('?ctl=user&act=studentLists');

		$limit = $pager->limit;
	
		$sql = "SELECT * FROM kp_user ORDER BY uid DESC LIMIT ".$limit;

		$row = $this->db->doSql($sql,$params);

		$this->smarty->assign('showpage',$showpage);
		$this->smarty->assign('row',$row);
		$this->smarty->assign('show','user');
		$this->smarty->setTempDir_admin();
		$this->smarty->display('user_lists.html');
	}

	//添加学员页面
	public function addStudentPage(){
		$this->smarty->setTempDir_admin();
		//分类
		$sql1 = "SELECT * FROM kp_section";
		$section = DatabaseHandler::GetAll($sql1);
		$this->smarty->assign('section',$section);
		$this->smarty->assign('show','user');
		$this->smarty->display('add_student.html');
	}

	//批量添加学员页面
	public function batAddStudentPage(){
		$this->smarty->setTempDir_admin();
		$this->smarty->assign('show','user');
		$this->smarty->display('batadd_student.html');
	}

	//手动添加单个学员
	public function addStudent(){
		extract($_POST);
		//验证
		if($name == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入姓名'));
			return false;
		}
		if($sex == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请选择性别'));
			return false;
		}
		if($student_id == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入学员 学号/身份证号'));
			return false;
		}
		if($password1 == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入密码'));
			return false;
		}
		if($password1 != $password2){
			echo json_encode(array('res'=>'failed','msg'=>'两次密码输入不一致,请重新输入'));
			return false;
		}
		if($category == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请选择学校/专业/年级/科目'));
			return false;
		}
		// if($school == ''){
		// 	echo json_encode(array('res'=>'failed','msg'=>'请输入学校'));
		// 	return false;
		// }
		// if($majors == ''){
		// 	echo json_encode(array('res'=>'failed','msg'=>'请输入专业'));
		// 	return false;
		// }
		// if($grade == ''){
		// 	echo json_encode(array('res'=>'failed','msg'=>'请输入年级'));
		// 	return false;
		// }
		// if($course == ''){
		// 	echo json_encode(array('res'=>'failed','msg'=>'请输入科目'));
		// 	return false;
		// }
		// 
		$sql1 = "SELECT * FROM kp_section where id=$category";
		$section = DatabaseHandler::GetRow($sql1);

		$res = userModel::addStudent($name, $sex, $student_id, hashencode($password1), $section['school'], $section['majors'], $section['grade'], $section['course'], $section['id']);

		if(empty($res))
			echo json_encode(array('res'=>'failed','msg'=>'数据错误!'));
		else
			echo json_encode(array('res'=>'success','msg'=>'添加成功'));

	}

	//上传文件批量添加
	public function batAddStudent(){
		//var_export($_FILES);
		$uploader = new include_upload();
		$uploader->setUploadConfig(getAppInf('upload_student'));
		$uploader->setUploadArray($_FILES['fileToUpload']);
		if($uploader->move()){
			$file= $uploader->upfilename;
		}else{
			echo json_encode(array('res'=>'failed','msg'=>'文件上传失败'));
			return false;
		}
		
		$dir = DOCUMENT_ROOT.'/uploads/student/';

		require_once DOCUMENT_ROOT.'/include/PHPExcel/Classes/PHPExcel.php';
		require_once DOCUMENT_ROOT.'/include/PHPExcel/Classes/PHPExcel/IOFactory.php';
		require_once DOCUMENT_ROOT.'/include/PHPExcel/Classes/PHPExcel/Reader/Excel5.php';
		$filename = $dir.$file;
		$PHPReader = new PHPExcel_Reader_Excel2007();
		if(!$PHPReader->canRead($filename)){
			$PHPReader = new PHPExcel_Reader_Excel5();
			if(!$PHPReader->canRead($filename)){
				echo json_encode(array('res'=>'failed','msg'=>'无法识别的文件！'));
				return false;
			}	
		}

		//载入文件
        $PHPExcel = $PHPReader->load($filename);
        //获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
        $currentSheet = $PHPExcel->getSheet(0);
        //获取总列数
        $allColumn = $currentSheet->getHighestColumn();
        //获取总行数
        $allRow = $currentSheet->getHighestRow();
        //循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
        for ($currentRow = 2; $currentRow <= $allRow; $currentRow++) {
            //从哪列开始，A表示第一列
            for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {
                //数据坐标
                $address = $currentColumn . $currentRow;
                //读取到的数据，保存到数组$data中
                $cell = $currentSheet->getCell($address)->getValue();
 
                if ($cell instanceof PHPExcel_RichText) {
                    $cell = $cell->__toString();
                }
                $data[$currentRow - 1][$currentColumn] = $cell;
            }
 
        }

        $splice = '';
        foreach($data as $k => $v){
        	$v['D'] = hashencode($v['D']);
        	$v['B'] = $v['B'] == "男" ? "m" : "f";
        	$splice .= "('{$v['A']}','{$v['B']}','{$v['C']}','{$v['D']}','{$v['E']}','{$v['F']}','{$v['G']}','{$v['H']}'),";
        }

        $splice = rtrim($splice,',');
        $res = userModel::batAddStudent($splice);
        if(empty($res)){
        	echo json_encode(array('res'=>'failed','msg'=>'导入失败!'));
			return false;
        }else
        	echo json_encode(array('res'=>'success','msg'=>'导入成功!'));

	}

	//编辑学员资料
	public function editStudentPage(){
		$uid = $_REQUEST['uid'];
		$row = userModel::getStudent($uid);
		$this->smarty->assign('row',$row);
		$this->smarty->assign('show','user');
		$this->smarty->setTempDir_admin();
		$this->smarty->display('edit_student.html');
	}

	public function editStudent(){
		extract($_POST);
		//验证
		if($uid == ''){
			echo json_encode(array('res'=>'failed','msg'=>'网络错误'));
			return false;
		}
		if($name == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入姓名'));
			return false;
		}
		if($sex == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请选择性别'));
			return false;
		}
		if($student_id == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入学员 学号/身份证号'));
			return false;
		}
		if($school == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入学校'));
			return false;
		}
		if($majors == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入专业'));
			return false;
		}
		if($grade == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入年级'));
			return false;
		}
		if($course == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入科目'));
			return false;
		}

		$res = userModel::editStudent($uid, $name,$sex, $student_id, $school, $majors, $grade, $course);

		if(empty($res))
			echo json_encode(array('res'=>'failed','msg'=>'数据错误!'));
		else
			echo json_encode(array('res'=>'success','msg'=>'添加成功'));
	}

	public function delStudent(){
		$uid = $_REQUEST['uid'];
		$gourl = !isset($_REQUEST['gourl']) ? '/student' : $_REQUEST['gourl'];
		userModel::delStudent($uid);
		echo json_encode(array('res'=>'success','msg'=>'删除成功','gourl'=>$gourl));
	}


	/***********************教师管理******************************/
	public function teacherLists(){
		$this->smarty->setTempDir_admin();

		$sql = "SELECT count(*) AS num FROM kp_admin_user WHERE roleid = 2";
		$num = DatabaseHandler::GetOne($sql);

		$p = isset($_GET['page']) ? intval($_GET['page']) : 1;
 		$pager = new include_page($num,10,$p);
		$showpage=$pager->showpage2('?ctl=user&act=teacherLists');

		$limit = $pager->limit;
	
		$sql = "SELECT * FROM kp_admin_user  WHERE roleid = 2 ORDER BY uid  LIMIT ".$limit;

		$row = $this->db->doSql($sql,$params);

		$this->smarty->assign('showpage',$showpage);
		$this->smarty->assign('row',$row);
		$this->smarty->assign('show','user');
		$this->smarty->display('teacher_list.html');
	}

	//添加学员页面
	public function addTeacherPage(){
		$this->smarty->setTempDir_admin();
		$this->smarty->assign('show','user');
		$this->smarty->display('add_teacher.html');
	}

	//手动添加单个教师
	public function addTeacher(){
		extract($_POST);
		//验证
		if($name == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入姓名'));
			return false;
		}
		if($teacher_id == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入教师账号'));
			return false;
		}
		if($password1 == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入密码'));
			return false;
		}
		if($password1 != $password2){
			echo json_encode(array('res'=>'failed','msg'=>'两次密码输入不一致,请重新输入'));
			return false;
		}


		$res = userModel::addTeacher($name, $teacher_id, hashencode($password1));

		if(empty($res))
			echo json_encode(array('res'=>'failed','msg'=>'数据错误!'));
		else
			echo json_encode(array('res'=>'success','msg'=>'添加成功'));

	}

	//编辑教师资料
	public function editTeacherPage(){
		$uid = $_REQUEST['uid'];
		$row = userModel::getTeacher($uid);
		$this->smarty->assign('row',$row);
		$this->smarty->assign('show','user');
		$this->smarty->setTempDir_admin();
		$this->smarty->display('edit_teacher.html');
	}

	//修改教师资料
	public function editTeacher(){
		extract($_POST);
		//验证
		if($uid == ''){
			echo json_encode(array('res'=>'failed','msg'=>'网络错误'));
			return false;
		}
		if($name == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入姓名'));
			return false;
		}
		if($teacher_id == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入学员 学号/身份证号'));
			return false;
		}
		

		$res = userModel::editTeacher($uid, $name, $teacher_id);

		if(empty($res))
			echo json_encode(array('res'=>'failed','msg'=>'数据错误!'));
		else
			echo json_encode(array('res'=>'success','msg'=>'添加成功'));
	}

	public function delTeacher(){
		$uid = $_REQUEST['uid'];
		$gourl = !isset($_REQUEST['gourl']) ? '/teacher' : $_REQUEST['gourl'];
		userModel::delTeacher($uid);
		echo json_encode(array('res'=>'success','msg'=>'删除成功','gourl'=>$gourl));
	}


	/**********************************管理员********************************/
	public function adminLists(){

		$sql = "SELECT count(*) AS num FROM kp_admin_user WHERE roleid != 2";
		$num = DatabaseHandler::GetOne($sql);

		$p = isset($_GET['page']) ? intval($_GET['page']) : 1;
 		$pager = new include_page($num,10,$p);
		$showpage=$pager->showpage2('?ctl=exam&act=adminLists');

		$limit = $pager->limit;
	
		$sql = "SELECT * FROM kp_admin_user WHERE roleid != 2 ORDER BY uid  LIMIT ".$limit;

		$row = $this->db->doSql($sql);

		$this->smarty->assign('showpage',$showpage);
		$this->smarty->assign('row',$row);
		$this->smarty->assign('show','user');
		$this->smarty->setTempDir_admin();
		$this->smarty->display('admin_list.html');
	}

	public function addAdminPage(){
		$this->smarty->setTempDir_admin();
		$this->smarty->assign('show','user');
		$this->smarty->display('add_admin.html');
	}

	//手动添加管理员
	public function addAdmin(){
		extract($_POST);
		//验证
		if($name == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入姓名'));
			return false;
		}
		if($account == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入账号'));
			return false;
		}
		if($password1 == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入密码'));
			return false;
		}
		if($password1 != $password2){
			echo json_encode(array('res'=>'failed','msg'=>'两次密码输入不一致,请重新输入'));
			return false;
		}
		$ip = getIpaddr();
		$datetime = date('Y-m-d h:i:s',time());
		$res = userModel::addAdmin($name, $account, hashencode($password1), $role, $datetime);

		if(empty($res))
			echo json_encode(array('res'=>'failed','msg'=>'数据错误!'));
		else
			echo json_encode(array('res'=>'success','msg'=>'添加成功'));
	}

	//编辑管理员资料
	public function editAdminPage(){
		$uid = $_REQUEST['uid'];
		$row = userModel::getAdmin($uid);
		$this->smarty->assign('row',$row);
		$this->smarty->assign('show','user');
		$this->smarty->setTempDir_admin();
		$this->smarty->display('edit_admin.html');
	}

	//修改管理员资料
	//手动添加管理员
	public function editAdmin(){
		extract($_POST);
		//验证
		if($uid == ''){
			echo json_encode(array('res'=>'failed','msg'=>'网络错误'));
			return false;
		}
		if($name == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入姓名'));
			return false;
		}

		$res = userModel::editAdmin($uid, $name, $role);

		if(empty($res))
			echo json_encode(array('res'=>'failed','msg'=>'数据错误!'));
		else
			echo json_encode(array('res'=>'success','msg'=>'修改成功'));
	}

	public function delAdmin(){
		$uid = $_REQUEST['uid'];
		$gourl = !isset($_REQUEST['gourl']) ? '/adminuser' : $_REQUEST['gourl'];
		userModel::delAdmin($uid);
		echo json_encode(array('res'=>'success','msg'=>'删除成功','gourl'=>$gourl));
	}
}