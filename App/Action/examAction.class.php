<?php
/**
 * Displays : 登陆模块
 * Author   : xy
 * Date     : 2020-09-01
 */

class examAction extends include_init
{

	public function __construct(){
		parent::__construct();
		header("Content-type:text/html;charset=utf-8");
		if(empty($_SESSION['userdetail'])) {
			Header("Location: /adminLogin");
			return false;
		}
	}


	//试卷分类页面
	public function examCategoryPage(){
		$sql = "SELECT count(*) AS num FROM kp_section";
		$num = DatabaseHandler::GetOne($sql);

		$p = isset($_GET['page']) ? intval($_GET['page']) : 1;
 		$pager = new include_page($num,10,$p);
		$showpage=$pager->showpage2('?ctl=exam&act=examCategoryPage');

		$limit = $pager->limit;
	
		$sql = "SELECT * FROM kp_section ORDER BY id LIMIT ".$limit;

		$row = $this->db->doSql($sql);

		$this->smarty->assign('showpage',$showpage);
		$this->smarty->assign('row',$row);
		$this->smarty->assign('show','exam');
		$this->smarty->setTempDir_admin();
		$this->smarty->display('exam_category.html');
	}

	//添加试卷分类
	public function AddExamCategoryPage(){
		$this->smarty->setTempDir_admin();
		$this->smarty->assign('show','exam');
		$this->smarty->display('exam_category_add.html');
	}

	//添加试卷
	public function AddExamCategory(){
		extract($_POST);

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
		if($term == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入年级'));
			return false;
		}
		if($course == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入科目'));
			return false;
		}

		$res = examModel::addExamCategory($school, $majors, $grade, $term, $course);

		if(empty($res))
			echo json_encode(array('res'=>'failed','msg'=>'数据错误!'));
		else
			echo json_encode(array('res'=>'success','msg'=>'添加成功'));
	}

	//编辑考试分类页面
	public function editExamCategoryPage(){
		$id = $_REQUEST['id'];
		$row = examModel::getCategory($id);
		$this->smarty->assign('row',$row);
		$this->smarty->assign('show','exam');
		$this->smarty->setTempDir_admin();
		$this->smarty->display('exam_category_edit.html');
	}
	//修改分类
	public function editExamCategory(){
		extract($_POST);
		//验证
		if($id == ''){
			echo json_encode(array('res'=>'failed','msg'=>'网络错误'));
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
		if($term == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入年级'));
			return false;
		}
		if($course == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入科目'));
			return false;
		}

		$res = examModel::editExamCategory($id, $school, $majors, $grade, $term, $course);

		if(empty($res))
			echo json_encode(array('res'=>'failed','msg'=>'数据错误!'));
		else
			echo json_encode(array('res'=>'success','msg'=>'添加成功'));
	}

	//删除试卷分类
	public function delExamCategory(){
		$id = $_REQUEST['id'];
		$gourl = !isset($_REQUEST['gourl']) ? '/exam/category' : $_REQUEST['gourl'];
		examModel::delExamCategory($id);
		echo json_encode(array('res'=>'success','msg'=>'删除成功','gourl'=>$gourl));
	}

	//创建试卷页面
	public function creatExamForCPage(){
		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
		$lists = examModel::getCategoryLists();
		$this->smarty->assign('id',$id);
		$this->smarty->assign('lists',$lists);
		$this->smarty->assign('show','exam');
		$this->smarty->setTempDir_admin();
		$this->smarty->display('exam_creat.html');
	}

	//创建试卷
	public function creatExam(){
		extract($_POST);

		if($title == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入试卷名称!'));
			return false;
		}
		if($category == 0){
			echo json_encode(array('res'=>'failed','msg'=>'请选择试卷分类!'));
			return false;
		}
		if($status == 0){
			echo json_encode(array('res'=>'failed','msg'=>'请选择试卷状态!'));
			return false;
		}
		if($pass_line == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入及格线!'));
			return false;
		}

		$operator = $_SESSION['userdetail']['uid'];
		$addtime = date('Y-m-d h:i:s',time());

		$res = examModel::creatExam($title, $category, $status, $pass_line, $operator, $addtime);

		if(empty($res))
			echo json_encode(array('res'=>'failed','msg'=>'数据错误!'));
		else
			echo json_encode(array('res'=>'success','msg'=>'创建成功'));
	}


	public function examLists(){
		$sql = "SELECT count(*) AS num FROM kp_exampaper";
		$num = DatabaseHandler::GetOne($sql);

		$p = isset($_GET['page']) ? intval($_GET['page']) : 1;
 		$pager = new include_page($num,10,$p);
		$showpage=$pager->showpage2('?ctl=exam&act=examLists');

		$limit = $pager->limit;
	
		$sql = "SELECT s.`school`,s.`majors`,s.`grade`,s.`term`,s.`course`,e.`id`,e.title,a.`name`,e.`status`,e.`pass_line`,e.`addtime` 
				FROM kp_exampaper e 
				JOIN kp_section s ON e.`sid` = s.`id`
				JOIN kp_admin_user a ON e.`operator` = a.`uid` LIMIT ".$limit;

		$row = $this->db->doSql($sql);

		$this->smarty->assign('showpage',$showpage);
		$this->smarty->assign('row',$row);
		$this->smarty->assign('show','exam');
		$this->smarty->setTempDir_admin();
		$this->smarty->display('exam_lists.html');
	}

	//修改试卷页面
	public function editExamPage(){
		$id = $_REQUEST['id'];
		$row = examModel::getExam($id);
		$lists = examModel::getCategoryLists();
		$this->smarty->assign('row',$row);
		$this->smarty->assign('lists',$lists);
		$this->smarty->assign('show','exam');
		$this->smarty->setTempDir_admin();
		$this->smarty->display('edit_exam.html');
	}

	//修改试卷
	public function editExam(){
		extract($_POST);
		//验证
		if($id == ''){
			echo json_encode(array('res'=>'failed','msg'=>'网络错误'));
			return false;
		}
		if($title == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入试卷名称!'));
			return false;
		}
		if($category == 0){
			echo json_encode(array('res'=>'failed','msg'=>'请选择试卷分类!'));
			return false;
		}
		if($status == 0){
			echo json_encode(array('res'=>'failed','msg'=>'请选择试卷状态!'));
			return false;
		}
		if($pass_line == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入及格线!'));
			return false;
		}

		$res = examModel::editExam($id, $title, $category, $status, $pass_line);

		if(empty($res))
			echo json_encode(array('res'=>'failed','msg'=>'数据错误!'));
		else
			echo json_encode(array('res'=>'success','msg'=>'修改成功'));
	}



	/****************************题型***********************************/
	public function examQuestype(){
		$sql = "SELECT * FROM kp_questype";
		$row = $this->db->doSql($sql);
		$this->smarty->assign('row',$row);
		$this->smarty->setTempDir_admin();
		$this->smarty->assign('show','exam');
		$this->smarty->display('exam_questype.html');
	}

	public function addExamQuestypePage(){
		$this->smarty->setTempDir_admin();
		$this->smarty->assign('show','exam');
		$this->smarty->display('exam_questype_add.html');
	}

	public function addExamQuestype(){
		extract($_POST);
		//验证
		if($questype == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入题型名称'));
			return false;
		}
	
		$res = examModel::addExamQuestype($questype);

		if(empty($res))
			echo json_encode(array('res'=>'failed','msg'=>'数据错误!'));
		else
			echo json_encode(array('res'=>'success','msg'=>'添加成功'));
	}

	//删除题型
	public function delExamQuestype(){
		$id = $_REQUEST['id'];
		examModel::delExamQuestype($id);
		echo json_encode(array('res'=>'success','msg'=>'删除成功'));
	}

	//创建试题页面
	public function creatExamQuestionPage(){
		$id = $_REQUEST['id'];
		$sql1 = "SELECT s.`school`,s.`majors`,s.`grade`,s.`term`,s.`course`,e.`id`,e.title
				FROM kp_exampaper e 
				JOIN kp_section s ON e.`sid` = s.`id`";
		$exam = DatabaseHandler::GetAll($sql1);

		$sql2 = "SELECT * FROM kp_questype";
		$row = $this->db->doSql($sql2);
		$this->smarty->assign('row',$row);
		$this->smarty->assign('id',$id);

		$this->smarty->assign('exam',$exam);
		$this->smarty->assign('show','exam');
		$this->smarty->setTempDir_admin();
		$this->smarty->display('exam_questions_add.html');
	}

	public function creatExamQuestion(){
		extract($_POST);

		if($exam == 0){
			echo json_encode(array('res'=>'failed','msg'=>'请选择试卷'));
			return false;
		}
		if($questype == 0){
			echo json_encode(array('res'=>'failed','msg'=>'请选择题型'));
			return false;
		}
		if($question == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入题目'));
			return false;
		}
		if(($questype == 1 || $questype == 2) && $option == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入选项'));
			return false;
		}
		if($answer == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入答案'));
			return false;
		}
		if($score == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入分值'));
			return false;
		}

		$res = examModel::creatExamQuestion($exam, $questype, $question, $option, $answer, $score);

		if(empty($res))
			echo json_encode(array('res'=>'failed','msg'=>'数据错误!'));
		else
			echo json_encode(array('res'=>'success','msg'=>'创建成功'));
	}

	//批量导入试题
	public function batCreatExamQuestionPage(){
		$id = $_REQUEST['id'];
		$this->smarty->assign('id',$id);
		$this->smarty->setTempDir_admin();
		$this->smarty->display('exam_questions_batadd.html');
	}

	//上传文件批量添加
	public function batCreatExamQuestion(){
		$id = $_REQUEST['id'];
		if(empty($id)){
			echo json_encode(array('res'=>'failed','msg'=>'数据错误'));
			return false;
		}
		$uploader = new include_upload();
		$uploader->setUploadConfig(getAppInf('upload_exam'));
		$uploader->setUploadArray($_FILES['fileToUpload']);
		if($uploader->move()){
			$file= $uploader->upfilename;
		}else{
			echo json_encode(array('res'=>'failed','msg'=>'文件上传失败'));
			return false;
		}
		
		$dir = DOCUMENT_ROOT.'/uploads/exam/';

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

		
		$sql = "SELECT * FROM kp_questype";
		$row = $this->db->doSql($sql);

        $splice = '';
        foreach($row as $k => $v){
        	foreach($data as $m => $n){
        		if($v['questype'] == $n['B']){
        			$data[$m]['F'] = $v['id'];
        		}
        	}
        }

		foreach($data as $k=>$v){
			if($v['A'] == '') return;
			$splice .= "('{$id}','{$v['F']}','{$v['A']}','{$v['C']}','{$v['D']}','{$v['E']}'),";
		}
        $splice = rtrim($splice,',');

        $res = examModel::batCreatExamQuestion($splice);
        if(empty($res)){
        	echo json_encode(array('res'=>'failed','msg'=>'导入失败!'));
			return false;
        }else
        	echo json_encode(array('res'=>'success','msg'=>'导入成功!'));

	}

	/****************************考试管理********************************/

	public function examTest(){
		$sql = "SELECT count(*) AS num FROM kp_test";
		$num = DatabaseHandler::GetOne($sql);

		$p = isset($_GET['page']) ? intval($_GET['page']) : 1;
 		$pager = new include_page($num,10,$p);
		$showpage=$pager->showpage2('?ctl=exam&act=examTest');

		$limit = $pager->limit;
	
		$sql = "SELECT s.`school`,s.`majors`,s.`grade`,s.`term`,s.`course`,e.title,a.`name`,t.*
				FROM kp_test t 
				JOIN kp_exampaper e ON t.`tid` = e.`id`
				JOIN kp_admin_user a ON t.`grader`  = a.`uid`
				JOIN kp_section s ON t.`sid` = s.`id` ORDER BY t.id  LIMIT ".$limit;

		$row = $this->db->doSql($sql,$params);

		$this->smarty->assign('showpage',$showpage);
		$this->smarty->assign('row',$row);
		$this->smarty->setTempDir_admin();
		$this->smarty->assign('show','test');
		$this->smarty->display('exam_test.html');
	}

	public function addExamTestPage(){
		//分类
		$sql1 = "SELECT * FROM kp_section";
		$section = DatabaseHandler::GetAll($sql1);
		//试卷
		$sql2 = "SELECT * FROM kp_exampaper";
		$exampaper = DatabaseHandler::GetAll($sql2);

		//批卷老师
		$sql3 = "SELECT * FROM kp_admin_user WHERE roleid = 2";
		$teacher = DatabaseHandler::GetAll($sql3);

		$this->smarty->assign('exampaper',$exampaper);
		$this->smarty->assign('section',$section);
		$this->smarty->assign('teacher',$teacher);
		$this->smarty->setTempDir_admin();
		$this->smarty->assign('show','test');
		$this->smarty->display('add_exam_test.html');
	}

	public function addExamTest(){

		extract($_POST);
		//验证
		if($title == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入考试名称'));
			return false;
		}
		if($category == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请选择考试分类'));
			return false;
		}
		if($exam == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请选择试卷'));
			return false;
		}
		if($grader == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请选择阅卷老师'));
			return false;
		}
		if($begain_time == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入考试开始时间'));
			return false;
		}
		if($end_time == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入考试结束时间'));
			return false;
		}

		$res = examModel::addExamTest($category, $exam,$title, str_replace("T"," ",$begain_time), str_replace("T"," ",$end_time),$grader,$is_make_up);

		if(empty($res))
			echo json_encode(array('res'=>'failed','msg'=>'数据错误!'));
		else
			echo json_encode(array('res'=>'success','msg'=>'添加成功'));
	}


	public function seeStudentGrade()
	{
		$id = $_REQUEST['id'];
		if(empty($id)){
			echo json_encode(array('res'=>'failed','msg'=>'数据错误'));
			return false;
		}
		//获取试卷的详细信息
		$testInfo = examModel::test($id);
		$sql1 = "SELECT * FROM kp_section where id=".$testInfo['tid'];
		$section = DatabaseHandler::GetRow($sql1);
		$testInfo['section'] = $section['school'].'/'.$section['majors'].'/'.$section['grade'].'/'.$section['term'].'/'.$section['course'];

		//获取当场考试所有考生的信息
		$studentList = examModel::getExamFromUserGroupTestnum($id);
		foreach ($studentList as $key => $value) {
			$studentTotalScore = examModel::sumStudentScore($value['uid'],$id);
			$studentList[$key]['score'] = $studentTotalScore['score'];
			if (floatval($studentTotalScore) < 60) {
				$studentList[$key]['is_jige'] = '否';
			} else {
				$studentList[$key]['is_jige'] = '是';
			}
			if ($value['is_reviewe'] == 1) {
				$studentList[$key]['is_reviewe'] = '已提交';
			} else {
				$studentList[$key]['is_reviewe'] = '未提交';
			}

			if ($value['create_time'] >= strtotime($testInfo['end_time'])) {
				$studentList[$key]['is_qiangzhi'] = '是';
			} else {
				$studentList[$key]['is_qiangzhi'] = '否';
			}
			$studentList[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
			//获取用户详细信息
			$studentInfo = userModel::getStudent($value['uid']);
			$studentList[$key]['student_id'] = $studentInfo['student_id'];
			$studentList[$key]['student_name'] = $studentInfo['name'];
			$studentList[$key]['student_majors'] = $studentInfo['majors'].'/'.$studentInfo['course'];
		}

		$this->smarty->assign('test',$testInfo);
		$this->smarty->assign('list',$studentList);
		$this->smarty->assign('list_count',count($studentList));
		$this->smarty->setTempDir_admin();
		$this->smarty->assign('show','test');
		$this->smarty->display('student_grade.html');
	}

	public function delAll()
	{
		$uid = $_REQUEST['uid'];//字符串
		//var_dump($uid);exit;
		$test_num = $_REQUEST['test_num'];
		$res = examModel::delUserTest($uid, $test_num);
		if ($res) {
			echo json_encode(array('res'=>'success','msg'=>'删除失败'));
		} else {
			echo json_encode(array('res'=>'failed','msg'=>'删除成功'));
		}	
	}

	public function export()
	{
		$uid = $_REQUEST['uid'];//字符串
		$id = $_REQUEST['test_num'];
        
		if(empty($id)){
			echo json_encode(array('res'=>'failed','msg'=>'数据错误'));
			return false;
		}
		//获取试卷的详细信息
		$testInfo = examModel::test($id);
		$sql1 = "SELECT * FROM kp_section where id=".$testInfo['tid'];
		$section = DatabaseHandler::GetRow($sql1);
		$testInfo['section'] = $section['school'].'/'.$section['majors'].'/'.$section['grade'].'/'.$section['term'].'/'.$section['course'];

		//获取当场考试所有考生的信息
		$studentList = examModel::getExamFromUserGroupUid($uid, $id);

		//var_dump($studentList);exit;
		foreach ($studentList as $key => $value) {
			$studentTotalScore = examModel::sumStudentScore($value['uid'],$id);
			$studentList[$key]['score'] = $studentTotalScore['score'];
			if (floatval($studentTotalScore) < 60) {
				$studentList[$key]['is_jige'] = '否';
			} else {
				$studentList[$key]['is_jige'] = '是';
			}
			if ($value['is_reviewe'] == 1) {
				$studentList[$key]['is_reviewe'] = '已提交';
			} else {
				$studentList[$key]['is_reviewe'] = '未提交';
			}

			if ($value['create_time'] >= strtotime($testInfo['end_time'])) {
				$studentList[$key]['is_qiangzhi'] = '是';
			} else {
				$studentList[$key]['is_qiangzhi'] = '否';
			}
			$studentList[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
			//获取用户详细信息
			$studentInfo = userModel::getStudent($value['uid']);
			$studentList[$key]['student_id'] = $studentInfo['student_id'];
			$studentList[$key]['student_name'] = $studentInfo['name'];
			$studentList[$key]['student_school'] = $studentInfo['school'];
			$studentList[$key]['student_majors'] = $studentInfo['majors'];
			$studentList[$key]['student_grade'] = $studentInfo['grade'];
			$studentList[$key]['student_course'] = $studentInfo['course'];
		}

		$data = array();
		foreach ($studentList as $key => $value) {
			$data[$key]['student_id'] = $value['student_id'];
			$data[$key]['student_name'] = $value['student_name'];
			$data[$key]['student_school'] = $value['student_school'];
			$data[$key]['student_majors'] = $value['student_majors'];
			$data[$key]['student_grade'] = $value['student_grade'];
			$data[$key]['student_course'] = $value['student_course'];
			$data[$key]['test_name'] = $testInfo['title'];
			$data[$key]['begin_time'] = $testInfo['begin_time'];
			$data[$key]['end_time'] = $value['create_time'];
			$data[$key]['score'] = $value['score'];
			$data[$key]['is_jige'] = $value['is_jige'];
			$data[$key]['is_bukao'] = '否';
			if ($value['is_qiangzhi'] = "是") {
				$data[$key]['is_qiangzhi'] = $value['is_qiangzhi'].'(时间已到)';
			}
		}
		require_once DOCUMENT_ROOT.'/include/PHPExcel/Classes/PHPExcel.php';
		require_once DOCUMENT_ROOT.'/include/PHPExcel/Classes/PHPExcel/IOFactory.php';
		require_once DOCUMENT_ROOT.'/include/PHPExcel/Classes/PHPExcel/Reader/Excel5.php';
		$filename=$testInfo['title'];
		$headArr=array("学号","姓名",'院校',"年级","班级","专业","考试名称","开始时间","交卷时间","分数","及格","补考","强制交卷");
		$this->getExcel($filename,$headArr,$data);

	}

	private function getExcel($fileName,$headArr,$data){
            //对数据进行检验
            if(empty($data) || !is_array($data)){
                die("data must be a array");
            }
            //检查文件名
            if(empty($fileName)){
                exit;
            }
            $date = date("Y_m_d",time());
            $fileName .= "_{$date}.xls";

            //创建PHPExcel对象，注意，不能少了\
            $objPHPExcel = new \PHPExcel();
            $objProps = $objPHPExcel->getProperties();

            //设置表头
            $key = ord("A");
            foreach($headArr as $v){
                $colum = chr($key);
                $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
                $key += 1;
            }

            $column = 2;
            $objActSheet = $objPHPExcel->getActiveSheet();
            foreach($data as $key => $rows){ //行写入
                $span = ord("A");
                foreach($rows as $keyName=>$value){// 列写入
                    $j = chr($span);
                    $objActSheet->setCellValue($j.$column, $value);
                    $span++;
                }
                $column++;
            }

          
            $fileName = iconv("utf-8", "gb2312", $fileName);

            //重命名表
            // $objPHPExcel->getActiveSheet()->setTitle('test');
            //设置活动单指数到第一个表,所以Excel打开这是第一个表
            $objPHPExcel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment;filename=\"$fileName\"");
            header('Cache-Control: max-age=0');
            //var_dump(111);exit;
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            //var_dump($objWriter);exit;
            $result = $objWriter->save('php://output'); //文件通过浏览器下载
            

            exit;
        }

	public function piyue(){
		$id = $_REQUEST['id'];
		$uid = $_REQUEST['uid'];
		if(empty($id)){
			echo json_encode(array('res'=>'failed','msg'=>'数据错误'));
			return false;
		}


		$test = examModel::test($id);

		//试题
		$question = examModel::testQuestion($test['tid']);


		$this->smarty->assign('total',count($question));

		$keyName = array(
              'A','B','C','D','E','F',
              'G','H','I','J','K','L',
              'M','N','O','P','Q','R',
              'S','T','U','V','W','X',
              'Y','Z'
            );

		$dataGroup = $this->dataGroup($question,'questype');
		foreach($dataGroup as $k => $v){
			foreach($v as $m => $n){
				$score[$k]['score'] += $n['score'];
				if(!empty($n['option'])){
					$option = explode(',',$n['option']);
					$keyName2 = array_slice($keyName, 0, count($option));	
					$dataGroup[$k][$m]['option'] = array_combine($keyName2,$option);
					
				}
				if($n['questype'] == '填空题'){
					$anwswerNum = explode(',',$n['anwswer']);
					$dataGroup[$k][$m]['anwswerNum'] = $anwswerNum;
				}
			}
		}
		$studentScore = 0;

		foreach ($dataGroup as $key => $value) {
			foreach ($value as $key2 => $value2) {
				$userTestInfo = examModel::getUserTestInfo($uid, $value2['id']);

				if ($value2['questype'] == '判断题' || $value2['questype'] == '单选题' || $value2['questype'] == '多选题') {
					if ($userTestInfo['is_true'] == 1) {
						$studentScore += $userTestInfo['score'];
					}
					//查询当前题目学生是否正确
					$dataGroup[$key][$key2]['is_true'] = $userTestInfo['is_true'];
					$dataGroup[$key][$key2]['user_anwser'] = $userTestInfo['user_anwser'];
				} else {
					//查询当前题目学生是否正确
					$dataGroup[$key][$key2]['is_true'] = 0;
					$dataGroup[$key][$key2]['user_anwser'] = $userTestInfo['user_anwser'];
				}
			}
		}

		$userInfo = userModel::getStudent($uid);
		if (floatval($studentScore) < 60) {
			$userInfo['jige'] = 0;
		} else {
			$userInfo['jige'] = 1;
		}

		$this->smarty->setTempDir_admin();
		$this->smarty->assign('test',$test);
		$this->smarty->assign('user',$userInfo);
		$this->smarty->assign('question',$dataGroup);
		$this->smarty->assign('studentScore',$studentScore);
		$this->smarty->assign('show','test');
		$this->smarty->assign('score',$score);
		$this->smarty->display('piyue.html');
	}


	private function dataGroup( $dataArr=array(), $keyStr='')
    {
        $newArr=[];
        foreach ($dataArr as $k => $val) {    
            $newArr[$val[$keyStr]][] = $val;
        }
        return $newArr;
    }

    public function piyuePost()
    {
    	$uid = $_REQUEST['uid'];
    	$test_num = $_REQUEST['test_num'];
    	$tiid = $_POST['tiid'];//题目id和分数
    	$fens = $_POST['fens'];

    	$binary = $_POST['binary'];//判断题
		$single = $_POST['single'];//单选题
		$fill = $_POST['fill'];//填空题
		$duoxuan = $_POST['duoxuan'];//填空题
		$jisuan = $_POST['jisuan'];//填空题
		$wenda = $_POST['wenda'];//填空题
		$jianda = $_POST['jianda'];//填空题
		$zuopin = $_POST['zuopin'];//填空题
		foreach ($tiid as $key => $value) {
			foreach ($fens as $key2 => $value2) {
				//更改学生的实际分数
				examModel::updUserTest($value2, $uid,$test_num,$value);
			}
		}
		echo json_encode(array('res'=>'success','msg'=>'提交成功'));
    }

}
