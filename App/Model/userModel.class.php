<?php 
class userModel
{
	// 构造函数，建立对象时运行
	private function __construct()
	{
	}


	//学员列表
	public static function studentLists($limit=''){
		// $limit = explode(',', $limit);
		// $start_item = $limit[0];
		// $page_num = $limit[1];
		$sql = "SELECT * FROM kp_user ORDER BY uid  LIMIT ".$limit;
		//$params = array(':start_item'=>$start_item,':page_num'=>$page_num);

		return $this->db->doSql($sql,$params);
	}
	//添加单个学员
	public static function addStudent( $name='', $sex='m', $student_id='', $password='', $school='', $majors='', $grade='', $course='' , $section=0){
		$sql = "INSERT INTO kp_user (name, sex, student_id, password, school, majors, grade, course,section) VALUES('{$name}', '{$sex}', '{$student_id}', '{$password}', '{$school}', '{$majors}', '{$grade}', '{$course}', $section)";
		//$params = array(':name'=>$name, ':student_id'=>$student_id, ':password'=>$password, ':school'=>$school, ':majors'=>$majors, ':grade'=>$grade, ':course'=>$course);
		//var_export($params);die;
		return DatabaseHandler::ExecuteInsert($sql);
	}

	public static function batAddStudent($splice = ''){
		$sql = "INSERT INTO kp_user (name, sex, student_id, password, school, majors, grade, course) VALUES".$splice;
		return DatabaseHandler::ExecuteInsert($sql);
	}

	public static function getStudent($uid=0){
		$sql = "SELECT * FROM kp_user WHERE uid = :uid";
		$params = array(':uid'=>$uid);
		return DatabaseHandler::GetRow($sql,$params);
	}

	//修改学员信息
	public static function editStudent( $uid=0 ,$name='', $sex='', $student_id='', $school='', $majors='', $grade='', $course='' ){
		$sql = "UPDATE kp_user SET name = '{$name}', sex = '{$sex}', student_id = '{$student_id}', school = '{$school}', majors = '{$majors}', grade = '{$grade}', course = '{$course}' WHERE uid = $uid";
		return DatabaseHandler::ExecuteDelUpd($sql);
	}

	//删除学员信息
	public function delStudent($uid=0){
		$sql = "DELETE FROM `kp_user` WHERE `uid` = $uid";
		DatabaseHandler::ExecuteDelUpd($sql);
	}


	/******************************教师*********************************/
	public static function getTeacher($uid=0){
		$sql = "SELECT * FROM kp_admin_user WHERE uid = :uid AND roleid = 2";
		$params = array(':uid'=>$uid);
		return DatabaseHandler::GetRow($sql,$params);
	}

	public function addTeacher( $name='', $teacher_id='', $password='' ){
		$datetime = date('Y-m-d h:i:s',time());
		$sql = "INSERT INTO kp_admin_user (name, account, password ,roleid, addtime) VALUES('{$name}', '{$teacher_id}', '{$password}',2, '{$datetime}')";
		return DatabaseHandler::ExecuteInsert($sql);
	}

	//修改教师信息
	public static function editTeacher( $uid=0 ,$name='', $teacher_id='' ){
		$sql = "UPDATE kp_admin_user SET name = '{$name}', account = '{$teacher_id}' WHERE uid = $uid AND roleid = 2";
		return DatabaseHandler::ExecuteDelUpd($sql);
	}

	//删除教师信息
	public function delTeacher($uid=0){
		$sql = "DELETE FROM `kp_admin_user` WHERE `uid` = $uid AND roleid = 2";
		DatabaseHandler::ExecuteDelUpd($sql);
	}

	/******************************管理员****************************/
	//添加管理员
	public function addAdmin($name='', $account='', $password='', $roleid=0, $ip='', $datetime=''){
		$sql = "INSERT INTO kp_admin_user (name, account, password ,roleid,addtime) VALUES('{$name}', '{$account}', '{$password}', '{$roleid}','{$datetime}')";
		return DatabaseHandler::ExecuteInsert($sql);
	}
	
	//获取管理员资料
	public static function getAdmin($uid=0){
		$sql = "SELECT * FROM kp_admin_user WHERE uid = :uid";
		$params = array(':uid'=>$uid);
		return DatabaseHandler::GetRow($sql,$params);
	}

	//修改管理员资料
	public static function editAdmin($uid=0, $name='', $roleid=0){
		$sql = "UPDATE kp_admin_user SET name = '{$name}', roleid = '{$roleid}' WHERE uid = $uid";
		return DatabaseHandler::ExecuteDelUpd($sql);
	}

	//删除教师信息
	public function delAdmin($uid=0){
		$sql = "DELETE FROM `kp_admin_user` WHERE `uid` = $uid";
		DatabaseHandler::ExecuteDelUpd($sql);
	}
}


?>