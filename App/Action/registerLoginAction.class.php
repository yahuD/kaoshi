<?php

/**
 * Displays : 登陆模块
 * Author   : xy
 * Date     : 2020-09-01
 */

class registerLoginAction extends include_init
{

	public function __construct(){
		parent::__construct();
		header("Content-type:text/html;charset=utf-8");
	}

  


	//普通登陆
	public function loginPage(){
		$this->smarty->display('login.html');
	}

	public  function login(){
		extract($_POST);

		if(strtolower($code) != $_SESSION['user_randcode']){
			echo json_encode(array('res'=>'failed','msg'=>'验证码错误!'));
			return false;
		} 
		if($student_id == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入学号/身份证号'));
			return false;
		}
		if($name == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入姓名'));
			return false;
		}
		if($password == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入密码'));
			return false;
		}

		// if(!empty($remember)){//如果用户选择了，记录登录状态就把用户名和加了密的密码放到cookie里面
		// 	setcookie("name",$name,time()+3600*24*365);
		// 	setcookie("password",hashencode($password),time()+3600*24*365);
		// }

		$row = loginModel::getUser($student_id,$name);

		if(empty($row)){
			echo json_encode(array('res'=>'failed','msg'=>'用户名错误!'));
			return false;
		}

		if($row['password'] != hashencode($password)){
			echo json_encode(array('res'=>'failed','msg'=>'密码错误!'));
			return false;
		} 

		$_SESSION['user'] = $row;
		unset($_SESSION['user_randcode']);
		echo json_encode(array('res'=>'success','msg'=>'登录成功'));
	}

	public  function Mlogin(){
		extract($_POST);
//var_export($_POST);die;
		if($student_id == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入学号/身份证号'));
			return false;
		}
		if($name == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入姓名'));
			return false;
		}
		if($password == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入密码'));
			return false;
		}


		$row = loginModel::getUser($student_id,$name);

		if(empty($row)){
			echo json_encode(array('res'=>'failed_name','msg'=>'用户名错误!'));
			return false;
		}

		if($row['password'] != hashencode($password)){
			echo json_encode(array('res'=>'failed_pwd','msg'=>'密码错误!'));
			return false;
		} 

		$_SESSION['user'] = $row;
		echo json_encode(array('res'=>'success','msg'=>'登录成功'));
	}

	//管理员登录页面
	public function adminLoginPage(){
		$this->smarty->setTempDir_admin();
		if(!empty($_SESSION['userdetail'])) {
			Header("Location: ?ctl=registerLogin&act=adminindex");
			return false;
		}
		$this->smarty->display('admin_login.html');
	}

	public function adminindex(){
		if(empty($_SESSION['userdetail'])) {
			Header("Location: ?ctl=registerLogin&act=adminLoginPage");
			return false;
		}
		$this->smarty->setTempDir_admin();
		$this->smarty->assign('show', 'index');
		$this->smarty->display('index.html');
	}

	//管理员退出
	public function adminLogout(){
		unset($_SESSION['userdetail']);
		Header("Location: ?ctl=registerLogin&act=adminLoginPage");
	}

	//管理员登录
	public function adminLogin(){
		extract($_POST);

		if(strtolower($randcode) != $_SESSION['admin_randcode']){
			echo json_encode(array('res'=>'failed','msg'=>'验证码错误!'));
			return false;
		} 
		if($username == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入用户名'));
			return false;
		}
		if($password == ''){
			echo json_encode(array('res'=>'failed','msg'=>'请输入密码'));
			return false;
		}

		$row = loginModel::getAdminUser($username);

		if(empty($row)){
			echo json_encode(array('res'=>'failed','msg'=>'用户名错误!'));
			return false;
		}

		if($row['password'] != hashencode($password)){
			echo json_encode(array('res'=>'failed','msg'=>'密码错误!'));
			return false;
		}

		$_SESSION['userdetail'] = $row;
		unset($_SESSION['admin_randcode']);
		echo json_encode(array('res'=>'success','msg'=>'登录成功'));
		
		
	}

	//传输验证码
	public function getRandCode(){
		header("Content-type: image/png");
		$randCode = $this->setRandCode();
		$_SESSION['admin_randcode'] = strtolower($randCode);
		echo $this->createRandImage($randCode,100,42);
	}

	//传输验证码
	public function getRandCodeForUser(){
		header("Content-type: image/png");
		$randCode = $this->setRandCode();
		$_SESSION['user_randcode'] = strtolower($randCode);
		echo $this->createRandImage($randCode,100,42);
	}

	//生成验证码
	public function setRandCode()
    {
        $array = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9');
        $randCode = '';
        for($i=0;$i<4;$i++)
        {
            $randCode .= $array[intval(rand(0,35))];
        }
        
        return $randCode;
    }


	//创建随即验证码图片
    public function createRandImage($randCode = NULL,$width = 60, $height = 24,$mix = 50)
    {
    	$par = intval($width/4);
    	$randCode = strval($randCode);
    	$image = imagecreatetruecolor($width,$height);
    	$gray = ImageColorAllocate($image,0,0,0);
    	imagefill($image,0,0,$gray);
    	for($i = 0;$i<4;$i++)
    	{
	    	$text_color = imagecolorallocate($image, rand(128,255), rand(128,255), rand(128,255));
	    	//imagechar($image,20,7+$i*25,5+rand(3,8),(string)$randCode[$i],$text_color);  
			imagettftext($image,14,intval(rand(0,60)),10+$i*$par,23+rand(3,8), $text_color,DOCUMENT_ROOT.'/admin/fonts/VERDANA.TTF',$randCode[$i]);
    	}
    	for($i=0;$i<255;$i++)
		{
			$randcolor = ImageColorallocate($image,rand(0,255),rand(0,255),rand(0,255));
			imagesetpixel($image, rand(1,$width) , rand(1,$height) , $randcolor);
		}
    	imagepng($image);
		imagedestroy($image);
		return $randCode;
    }
}
?>