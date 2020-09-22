<?php
class indexAction extends include_init
{
	public function __construct()
	{
		parent::__construct();
		header("Content-type:text/html;charset=utf-8");
		if(empty($_SESSION['user'])){
			Header("Location: /?ctl=registerLogin&act=loginPage");
			return false;
		}
	}

	public function index(){
		//当前考试
		$uid = $_SESSION['user']['uid'];
		//获取学生所属分类
		$userInfo = userModel::getStudent($uid);
		if (empty($userInfo['section'])) {
			$userInfo['section'] = 1;
		}
		
		examModel::updExamStatus();
		$lists = examModel::getExamForUser('0,1', $userInfo['section']);
		$i=0;
		foreach($lists as $k=> $v){
			//循环判断当前考试时候已经参与
			$result = examModel::getIsRepeatTest($uid,$v['id']); 
			if ($result > 0){
				unset($lists[$k]);
				continue;
			} else {
				$lists[$k]['duration'] = floor((strtotime($v['end_time'])-strtotime($v['begin_time']))%86400/60);
				$lists[$k]['long'] = floor((strtotime($v['begin_time'])-time())%86400/60);
			}
		}
		if (empty($lists)) {
			$lists = array();
		}
		//找到分类下的所有考试--历史考试
		$sectionExam = examModel::getExamForUserWhereSection($userInfo['section']);
		$list3 = examModel::getExamFromUser($uid);
		foreach ($sectionExam as $key => $value) {
			foreach ($list3 as $key2 => $value2) {
				if ($value['id'] != $value2['test_num']) {
					$sectionExam[$key]['is_quekao'] = 1;
					continue;
				} else {
					$sectionExam[$key]['is_quekao'] = 0;
					continue;
				}
			}
		}




		$this->smarty->assign('list3',$sectionExam);

		$this->smarty->assign('lists',$lists);
		$this->smarty->assign('lists_count', count($lists));
		//print_r($lists);exit;
		$this->smarty->assign('user',$_SESSION['user']);
		$this->smarty->display('index.html');
	}


	//试题页面
	public function test(){
		$id = $_REQUEST['id'];
		if(empty($id)) alerterror('系统错误!');

		$test = examModel::test($id);
		
		//试题
		$question = examModel::testQuestion($test['tid']);
		$this->smarty->assign('test_title',$test['title']);

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

		$endtime = strtotime($test['end_time']);
		$nowtime  =   time();
		$lefttime = $endtime-$nowtime;  //实际剩下的时间（秒）
		if($lefttime <= 0) alerterror('考试已结束!');
		$this->smarty->assign('question',$dataGroup);
		$this->smarty->assign('lefttime',$lefttime);
		$this->smarty->assign('id',$id);
		$this->smarty->assign('score',$score);
		$this->smarty->display('tiku.html');
	}

	//试卷提交
	public function testPost(){
		$uid = $_SESSION['user']['uid'];
		$test_num = $_POST['test_num'];
		//判断是否已经考过了
		$result = examModel::getIsRepeatTest($uid,$test_num);

		if ($result > 0) {
			echo json_encode(array('res'=>'failed','msg'=>'您已经参与过本场考试'));
			exit;
		}


		$binary = $_POST['binary'];//判断题
		$single = $_POST['single'];//单选题
		$fill = $_POST['fill'];//填空题
		$duoxuan = $_POST['duoxuan'];//填空题
		$jisuan = $_POST['jisuan'];//填空题
		$wenda = $_POST['wenda'];//填空题
		$jianda = $_POST['jianda'];//填空题
		$zuopin = $_POST['zuopin'];//填空题

		$i = 0;
		$data = array();
		//判断题
		foreach ($binary as $key => $value) {
			$question = examModel::getQuestion($key);
			$data[$i]['test_id'] = $question['id'];
			$data[$i]['question_type'] = $question['questype'];
			$data[$i]['user_anwser'] = $value;
			$data[$i]['true_anwser'] = $question['anwswer'];
			if ($value == $question['anwswer']) {
				$data[$i]['is_true'] = 1;
				$data[$i]['score'] = $question['score'];
			} else {
				
				$data[$i]['is_true'] = 0;
				$data[$i]['score'] = 0;
			}
			$data[$i]['uid'] = $uid;
			$data[$i]['test_num'] = $test_num;
			$i++;
		}
		//单选题
		foreach ($single as $key => $value) {
			$question = examModel::getQuestion($key);
			$data[$i]['test_id'] = $question['id'];
			$data[$i]['question_type'] = $question['questype'];
			$data[$i]['user_anwser'] = $value;
			$data[$i]['true_anwser'] = $question['anwswer'];
			if ($value == $question['anwswer']) {
				$data[$i]['is_true'] = 1;
				$data[$i]['score'] = $question['score'];
			} else {
				
				$data[$i]['is_true'] = 0;
				$data[$i]['score'] = 0;
			}
			$data[$i]['uid'] = $uid;
			$data[$i]['test_num'] = $test_num;
			$i++;
		}
		//填空题（主观题）
		foreach ($fill as $key => $value) {
			$question = examModel::getQuestion($key);
			$data[$i]['test_id'] = $question['id'];
			$data[$i]['question_type'] = $question['questype'];
			$data[$i]['user_anwser'] = implode(',', $value);
			$data[$i]['true_anwser'] = $question['anwswer'];
			$data[$i]['is_true'] = 0;
			$data[$i]['score'] = 0;
			$data[$i]['uid'] = $uid;
			$data[$i]['test_num'] = $test_num;
			$i++;
		}
		//多选题
		foreach ($duoxuan as $key => $value) {
			$question = examModel::getQuestion($key);
			$data[$i]['test_id'] = $question['id'];
			$data[$i]['question_type'] = $question['questype'];
			$data[$i]['user_anwser'] = implode(',', $value);
			$data[$i]['true_anwser'] = $question['anwswer'];
			if (implode(',', $value) == $question['anwswer']) {
				$data[$i]['is_true'] = 1;
				$data[$i]['score'] = $question['score'];
			} else {
				
				$data[$i]['is_true'] = 0;
				$data[$i]['score'] = 0;
			}
			$data[$i]['uid'] = $uid;
			$data[$i]['test_num'] = $test_num;
			$i++;
		}
		//问答题（主观题）
		foreach ($wenda as $key => $value) {
			$question = examModel::getQuestion($key);
			$data[$i]['test_id'] = $question['id'];
			$data[$i]['question_type'] = $question['questype'];
			$data[$i]['user_anwser'] = $value;
			$data[$i]['true_anwser'] = $question['anwswer'];
			$data[$i]['is_true'] = 0;
			$data[$i]['score'] = 0;
			$data[$i]['uid'] = $uid;
			$data[$i]['test_num'] = $test_num;
			$i++;
		}

		//简答题（主观题）
		foreach ($jianda as $key => $value) {
			$question = examModel::getQuestion($key);
			$data[$i]['test_id'] = $question['id'];
			$data[$i]['question_type'] = $question['questype'];
			$data[$i]['user_anwser'] = $value;
			$data[$i]['true_anwser'] = $question['anwswer'];
			$data[$i]['is_true'] = 0;
			$data[$i]['score'] = 0;
			$data[$i]['uid'] = $uid;
			$data[$i]['test_num'] = $test_num;
			$i++;
		}

		//计算题（主观题）
		foreach ($jisuan as $key => $value) {
			$question = examModel::getQuestion($key);
			$data[$i]['test_id'] = $question['id'];
			$data[$i]['question_type'] = $question['questype'];
			$data[$i]['user_anwser'] = $value;
			$data[$i]['true_anwser'] = $question['anwswer'];
			$data[$i]['is_true'] = 0;
			$data[$i]['score'] = 0;
			$data[$i]['uid'] = $uid;
			$data[$i]['test_num'] = $test_num;
			$i++;
		}
		//作品题（主观题）
		foreach ($zuopin as $key => $value) {
			$question = examModel::getQuestion($key);
			$data[$i]['test_id'] = $question['id'];
			$data[$i]['question_type'] = $question['questype'];
			$data[$i]['user_anwser'] = $value;
			$data[$i]['true_anwser'] = $question['anwswer'];
			$data[$i]['is_true'] = 0;
			$data[$i]['score'] = 0;
			$data[$i]['uid'] = $uid;
			$data[$i]['test_num'] = $test_num;
			$i++;
		}


		foreach ($data as $key => $value) {
			examModel::addUserTestRecord($value['uid'],$value['test_id'],$value['question_type'],$value['user_anwser'],$value['true_anwser'],$value['is_true'],$value['score'],$value['test_num']);
		}

		echo json_encode(array('res'=>'success','msg'=>'提交成功'));
	}

	//手机端个人中心
	public function userCenter(){
		$this->smarty->setTempDir_mobile();
		$this->smarty->assign('user',$_SESSION['user']);
		$this->smarty->display('gerenzhongxin.html');
	}

	private function dataGroup( $dataArr=array(), $keyStr='')
    {
        $newArr=[];
        foreach ($dataArr as $k => $val) {    
            $newArr[$val[$keyStr]][] = $val;
        }
        return $newArr;
    }
    public function mindex(){
    	$uid = $_SESSION['user']['uid'];
		//获取学生所属分类
		$userInfo = userModel::getStudent($uid);
		if (empty($userInfo['section'])) {
			$userInfo['section'] = 1;
		}
		examModel::updExamStatus();
		$lists = examModel::getExamForUser('0,1', $userInfo['section']);
		$i=0;
		foreach($lists as $k=> $v){
			//循环判断当前考试时候已经参与
			$result = examModel::getIsRepeatTest($uid,$v['id']); 
			if ($result > 0){
				unset($lists[$k]);
				continue;
			} else {
				$lists[$k]['duration'] = floor((strtotime($v['end_time'])-strtotime($v['begin_time']))%86400/60);
				$lists[$k]['long'] = floor((strtotime($v['begin_time'])-time())%86400/60);
			}
		}
		if (empty($lists)) {
			$lists = array();
		}
		$this->smarty->assign('lists',$lists);
		$this->smarty->assign('lists_count', count($lists));
		//print_r($lists);exit;
		$this->smarty->assign('user',$_SESSION['user']);
		$this->smarty->setTempDir_mobile();
		$this->smarty->display('index.html');
	}

	public function index_more()
	{
		//当前用户已考试的
		$uid = $_SESSION['user']['uid'];
		//获取学生所属分类
		$userInfo = userModel::getStudent($uid);
		if (empty($userInfo['section'])) {
			$userInfo['section'] = 1;
		}
		examModel::updExamStatus();
		$lists = examModel::getExamForUser('0,1', $userInfo['section']);
		//$lists2 = examModel::getExamForUser('2');
		foreach($lists as $k=> $v){
			//循环判断当前考试时候已经参与
			$result = examModel::getIsRepeatTest($uid,$v['id']); 
			if ($result > 0){
				unset($lists[$k]);
				continue;
			} else {
				$lists[$k]['duration'] = floor((strtotime($v['end_time'])-strtotime($v['begin_time']))%86400/60);
				$lists[$k]['long'] = floor((strtotime($v['begin_time'])-time())%86400/60);
			}
		}

		if (empty($lists)) {
			$lists = array();
		}
		while (count($lists) > 1) {
			array_pop($lists);
		}
		$this->smarty->assign('lists',$lists);


		
		//找到分类下的所有考试
		$sectionExam = examModel::getExamForUserWhereSection($userInfo['section']);

		$list3 = examModel::getExamFromUser($uid);
		foreach ($sectionExam as $key => $value) {
			foreach ($list3 as $key2 => $value2) {
				if ($value['id'] != $value2['test_num']) {
					$sectionExam[$key]['is_quekao'] = 1;
					continue;
				} else {
					$sectionExam[$key]['is_quekao'] = 0;
					continue;
				}
			}
		}
		$this->smarty->assign('list3',$sectionExam);
		$this->smarty->setTempDir_mobile();
		$this->smarty->display('index_more.html');
	}

	// 手机端考试页面
	public function timu()
	{
		$id = $_REQUEST['id'];
		if(empty($id)) alerterror('系统错误!');
		$test = examModel::test($id);
		$this->smarty->assign('test_title',$test['title']);
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

		$endtime = strtotime($test['end_time']);
		$nowtime  =   time();
		$lefttime = $endtime-$nowtime;  //实际剩下的时间（秒）
		if($lefttime <= 0) alerterror('考试已结束!');
		$i = 0;
		foreach ($dataGroup as $key => $value) {
			$i += count($value);
		}
		$totalScore = 0;
		foreach ($score as $key => $value) {
			$totalScore += $value['score'];
		}
		$this->smarty->assign('question',$dataGroup);  //所有题目
		$this->smarty->assign('question_count',$i);  //总题数
		$this->smarty->assign('lefttime',$lefttime); //剩余时间
		$this->smarty->assign('id',$id);  //试卷id
		$this->smarty->assign('score',$score);//题型和对应总分值
		$this->smarty->setTempDir_mobile();
		$this->smarty->display('timu2.html');
	}

    public function logout(){
    	unset($_SESSION['user']);
    	Header("Location: /?ctl=registerLogin&act=loginPage");
    }

    public function testUpload(){
    	$this->smarty->display('tiku2.html');
    }

    public function upload(){

    	$url = '/uploads/answer/';
    	$uploader = new include_upload();
		$uploader->setUploadConfig(getAppInf('upload_answer'));
		$uploader->setUploadArray($_FILES['file']);
		if($uploader->move()){
			$filename= $uploader->upfilename;
		}
		$fileurl = $url.$filename;
		echo json_encode(array("code"=>0,"msg"=>'上传成功',"data"=>array("src"=>$fileurl,"title"=>$filename)));
    }
}
?>