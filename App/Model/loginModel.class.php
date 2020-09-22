<?php 
class loginModel
{
	// 构造函数，建立对象时运行
	private function __construct()
	{
	}

	//获取管理员或老师数据
	public static function getAdminUser($account=''){
		$sql = "SELECT uid,name,account,password,roleid FROM kp_admin_user WHERE account = :account";
		$params = array(':account'=>$account);
		$row = DatabaseHandler::GetRow($sql,$params);
		return $row;
	}

	public static function getUser($student_id='',$name=''){
		$sql = "SELECT uid,name,student_id,password,school,majors,grade,course FROM kp_user WHERE student_id = :student_id AND name = :name";
		$params = array(':student_id'=>$student_id, ':name'=>$name);
		$row = DatabaseHandler::GetRow($sql,$params);
		return $row;
	}
}

?>