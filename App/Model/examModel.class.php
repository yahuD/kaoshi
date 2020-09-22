<?php 

class examModel
{
	// 构造函数，建立对象时运行
	private function __construct()
	{
	}

	public static function addExamCategory($school='', $majors='', $grade='', $term='', $course=''){
		$sql = "INSERT INTO kp_section (school, majors, grade, term, course) VALUES('{$school}', '{$majors}', '{$grade}', '{$term}', '{$course}')";
		return DatabaseHandler::ExecuteInsert($sql);
	}

	public static function getCategory($id=0){
		$sql = "SELECT * FROM kp_section WHERE id = :id";
		$params = array(':id'=>$id);
		return DatabaseHandler::GetRow($sql,$params);
	}

	public function editExamCategory($id=0, $school='', $majors='', $grade='', $term='', $course=''){
		$sql = "UPDATE kp_section SET school = '{$school}', majors = '{$majors}', grade = '{$grade}',term = '{$term}', course = '{$course}' WHERE id = $id";
		return DatabaseHandler::ExecuteDelUpd($sql);
	}
	
	public function delExamCategory($id=0){
		$sql = "DELETE FROM `kp_section` WHERE `id` = $id";
		DatabaseHandler::ExecuteDelUpd($sql);
	}

	//获取试卷分类列表
	public static function getCategoryLists(){
		$sql = "SELECT * FROM kp_section";
		return DatabaseHandler::GetAll($sql);
	}

	public static function creatExam($title='', $category=0, $status=0, $pass_line=0, $operator='', $addtime=''){
		$sql = "INSERT INTO kp_exampaper (sid, title, status, pass_line, operator, addtime) VALUES('{$category}', '{$title}', '{$status}', '{$pass_line}', '{$operator}', '{$addtime}')";
		return DatabaseHandler::ExecuteInsert($sql);
	}

	public static function getExam($id){
		$sql = "SELECT * FROM kp_exampaper WHERE id = :id";
		$params = array(':id'=>$id);
		return DatabaseHandler::GetRow($sql,$params);
	}

	public static function editExam($id=0, $title='', $category=0, $status=0, $pass_line=0){
		$sql = "UPDATE kp_exampaper SET sid = '{$category}', title = '{$title}', status = '{$status}',pass_line = '{$pass_line}' WHERE id = $id";
		return DatabaseHandler::ExecuteDelUpd($sql);
	}

	public static function addExamQuestype($questype=''){
		$sql = "INSERT INTO kp_questype (questype) VALUES('{$questype}')";
		return DatabaseHandler::ExecuteInsert($sql);
	}

	public function delExamQuestype($id=0){
		$sql = "DELETE FROM `kp_questype` WHERE `id` = $id";
		DatabaseHandler::ExecuteDelUpd($sql);
	}
	public static function getQuestionType($typename='') {
		$sql = "SELECT * FROM kp_test_question WHERE questype = $typename";
		$result = DatabaseHandler::GetRow($sql);
		return $result['id'];
	}

	public function creatExamQuestion($exam=0, $questype=0, $question='', $option='', $answer='', $score=''){
		$sql = "INSERT INTO kp_test_question (eid, questype, question, anwswer, `option`, score) VALUES($exam, $questype, '{$question}', '{$answer}', '{$option}', '{$score}')";
		return DatabaseHandler::ExecuteInsert($sql);
	}

	public static function batCreatExamQuestion($splice = ''){
		$sql = "INSERT INTO kp_test_question (eid, questype, question, anwswer, `option`, score) VALUES".$splice;
		return DatabaseHandler::ExecuteInsert($sql);
	}

	public static function addExamTest( $category=0, $exam=0,$title='', $begain_time='', $end_time='',$grader=0,$is_make_up=0 ){
		$sql = "INSERT INTO kp_test (sid, tid, title, begin_time, `end_time`, grader, is_make_up) VALUES($category, $exam, '{$title}', '{$begain_time}', '{$end_time}', $grader, $is_make_up)";

		return DatabaseHandler::ExecuteInsert($sql);
	}


	//前端调用 未开始考试
	public static function getExamNoStart(){
		$sql  ="SELECT * FROM kp_test WHERE begin_time > NOW()";
		return DatabaseHandler::GetAll($sql);
	}

	public static function getExamForUser($status = '', $section=0){
		$sql  ="SELECT * FROM kp_test WHERE status IN ($status) and sid=$section";// WHERE begin_time > NOW()
		return DatabaseHandler::GetAll($sql);
	}
	public static function getExamForUserWhereSection($section=0){
		$sql  ="SELECT * FROM kp_test WHERE tid=$section";// WHERE begin_time > NOW()
		return DatabaseHandler::GetAll($sql);
	}

	//获取试题
	public static function testQuestion($eid=0){
		$sql = "SELECT t.*,q.`questype` FROM kp_test_question t JOIN kp_questype q ON t.`questype` = q.`id` WHERE eid = $eid";
		return DatabaseHandler::GetAll($sql);
	}

	public static function getQuestion($id=0) {
		$sql = "SELECT * FROM kp_test_question WHERE id = $id";
		return DatabaseHandler::GetRow($sql);
	}
	public static function addUserTestRecord( $uid=0, $test_id=0,$question_type=0, $user_anwser='', $true_anwser='',$is_true=0,$score=0,$test_num=0){
		$time = time();
		$sql = "INSERT INTO kp_user_test (uid, test_id, question_type, user_anwser, `true_anwser`, is_true,score,test_num,create_time) VALUES($uid, $test_id, $question_type, '{$user_anwser}', '{$true_anwser}', $is_true, $score, $test_num, $time)";
		return DatabaseHandler::ExecuteInsert($sql);
	}

	public static function test($id=0){
		$sql = "SELECT * FROM kp_test WHERE id = $id";
		return DatabaseHandler::GetRow($sql);
	}

	public static function getIsRepeatTest($uid=0, $test_num=0) {
		$sql = "SELECT count(1) FROM kp_user_test WHERE uid = $uid and test_num=$test_num";
		return DatabaseHandler::GetOne($sql);
	}
	public static function getUserTestInfo($uid=0, $test_id=0) {
		$sql = "SELECT * FROM kp_user_test WHERE uid = $uid and test_id=$test_id";
		return DatabaseHandler::GetRow($sql);
	}

	public static function getExamFromUser($uid=0) {
		$sql = "SELECT * FROM kp_user_test WHERE uid = $uid group by test_num";
		return DatabaseHandler::GetAll($sql);
	}
	public static function getExamFromUserGroupTestnum($test_num=0) {
		$sql = "SELECT * FROM kp_user_test WHERE test_num = $test_num group by uid";
		return DatabaseHandler::GetAll($sql);
	}

	public static function getExamFromUserGroupUid($uid = '', $test_num=0) {
		$sql = "SELECT * FROM kp_user_test WHERE test_num = $test_num and uid in ($uid) group by uid";
		return DatabaseHandler::GetAll($sql);
	}
	public static function sumStudentScore($uid=0,$test_num=0) {
		$sql = "SELECT sum(score) as score FROM kp_user_test WHERE test_num = $test_num and uid=$uid and question_type in (1,2,3)";
		return DatabaseHandler::GetRow($sql);
	}
	public static function delUserTest($uid='',$test_num=0) {
		$sql = "DELETE from kp_user_test where uid in ($uid) and test_num=$test_num";
		return DatabaseHandler::Execute($sql);
	}


	public static function updExamStatus() {
		$sql = "UPDATE kp_test SET status = 2 WHERE  end_time <= NOW()";
		DatabaseHandler::ExecuteDelUpd($sql);
	}
	public static function updUserTest($score = 0, $uid=0,$test_num=0,$test_id=0) {
		$sql = "UPDATE kp_user_test SET score = $score WHERE  uid=$uid and test_num=$test_num and test_id=$test_id";
		DatabaseHandler::ExecuteDelUpd($sql);
	}
}
?>