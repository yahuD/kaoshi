<?php

/**
 * Displays : 模板类
 * Author   : yinCY
 * Date     : Mon Nov 21 18:00:00 CST 2016
 
 * 警告：如果类名以smarty开头会与Smarty的Plugin文件命名冲突

 */

defined('PHPOX') or die(header("HTTP/1.1 403 Not Forbidden"));

class dtsmarty3 extends Smarty
{

	private static $instance;

	function __construct()
	{
   	  parent::__construct();

			if(is_mobile()){
					$this->setTempDir_mobile();
					// $this->setTempDir_pc();		
			}else{
					$this->setTempDir_pc();			
			}		
			
			$this->force_compile = SMARTY_FORCE_COMPILE;
			$this->debugging = false;	
			
//			$this->left_delimiter = '<!--@';
//			$this->right_delimiter = ' -->';
	
			$this->registerPlugin('function','url',array(& $this, '_pi_func_url'));						
			$this->registerPlugin('function','s12', array(& $this, '_pi_func_sales'));	
			$this->registerPlugin('function','round5', array(& $this, '_pi_func_round'));
			$this->registerPlugin('function','region', array(& $this, '_pi_func_region'));
			$this->registerPlugin('function','menu', array(& $this, '_pi_func_menu'));
			$this->registerPlugin('function','inf_option', array(& $this, '_pi_func_inf_option'));
			$this->registerPlugin('function','getbs', array(& $this, '_pi_func_getbs'));
			$this->registerPlugin('function','check_power', array(& $this, '_pi_func_check_power'));
			$this->registerPlugin('function','check_power2', array(& $this, '_pi_func_check_power2'));

			if (DEBUG === true){
				//$this->assign('debugMessageJson', json_encode($GLOBALS['debugMessage']) );
				$this->assign('debugMessage', $GLOBALS['debugMessage'] );		
			}

			if( isset($_SESSION['userdetail']) && !empty($_SESSION['userdetail']) ){
				$this->assign('sid',session_id());
				$this->assign('sname',session_name());
				$this->assign('userdetail',getUserInfo());
				$this->assign('isadmin',isadmin());
				$this->assign('islogin',islogin());
				$this->assign('login',getUid());
				$this->assign('isbbsadmin',isbbsadmin());	
			}
			
			if( isset($_SESSION['taobaouser']) && !empty($_SESSION['taobaouser']) ){
				$this->assign('istaobaologin',getTaobao());
				$this->assign('taobao',$_SESSION['taobaouser']);
			}
			
			$this->assign('cartshopnum',getcartshopnum());
			$this->assign('cartgiftnum',getcartgiftnum());
			$this->assign('is_wx',is_wx());
			$this->assign('CDN_DOMAIN_BASE',CDN_DOMAIN_BASE);
			$this->assign('CDN_DOMAIN_BBS',CDN_DOMAIN_BBS);
	}

	public static function getInstance(){
		if (self::$instance === null){
			self::$instance = new include_smarty();
		}
		return self::$instance;
	}

	public function _pi_func_sales($params, & $smarty){
		$yj = $params['yj'];
		$sales = $params['sales'];
		$yj = (float)$yj*(float)$sales;
		return round($yj,0);
	}
	public function _pi_func_round($params, & $smarty){
		$yj = $params['yj'];
		$yj = (float)$yj*1;
		return round($yj,0);
	}
	
	public function _pi_func_region($params,&$smarty){
		$region = new include_region();
		if($params['type'] == 'text'){
			return $region->getRegion($params['id']);
		}else{
			if($params['id']&&$params['p']&&$params['c'])
				return $region->getHtml($params['id'],$params['p'],$params['c'],$params['d']);
			else return $region->getHtml($params['id']);
		}
	}
	public function _pi_func_menu($params,&$smarty){
		unset($params);
		$catgegory = getSingleton('model_category');
		return $catgegory->gethtml();
	}
	public function _pi_func_getbs($params,&$smarty){
		$buysell = getSingleton('model_buysell');
		return $buysell->getbs($params['shopid'],$params['p'],$params['t1'],$params['t2']);
	}
	public function _pi_func_check_power($params,&$smarty){
		$ctl = $params['ctl'];
		$act = $params['act'];
		return check_userpower(NULL,NULL,$ctl,$act)?'':' style="display:none;"';
	}
	public function _pi_func_check_power2($params,&$smarty){
		return check_userpower2($params['power'],NULL)?'':' style="display:none;"';
	}
	public function _pi_func_inf_option($params,&$smarty){
		$all = getAppInf($params['inf']);
		return setOption($params['selected'],$all);
	}

	public function _pi_func_url($params, & $smarty){
		$ctl = $params['ctl'];
		$act = $params['act'];
		unset($params['ctl']);
		unset($params['act']);
		if ($ctl=='admin'&&$act=='orders'){
			if($_SESSION['userdetail']['roleid']==1){
				$ctl = 'mnl';
				$act = 'lists';
			}elseif($_SESSION['userdetail']['roleid']==4){
				$ctl = 'count';
				$act = 'show_order';
			}elseif($_SESSION['userdetail']['roleid']==5){
				$ctl = 'shop';
				$act = 'manage';
			}//elseif($_SESSION['userdetail']['roleid']==7){
				//$ctl = 'union';
				//$act = 'usermanage';
			//}
		}
		return url($ctl,$act,$params);
	}
	// 设置缓存	  yincy 16-09-29
	public function enable_cache( $duration = 900 )
	{
		$this->caching   = true;
		$this->cache_lifetime = $duration;
		$this->cache_dir = DOCUMENT_ROOT.'/smartycache/';
	}
	
	public function setTempDir_pc(){
				$this->setTemplateDir(DOCUMENT_ROOT.'/template/');	
				$this->setCompileDir(DOCUMENT_ROOT.'/template_c/');
	}

	public function setTempDir_mobile(){
				//$this->left_delimiter = '<!--@';
				// $this->right_delimiter = ' -->';
				$this->setTemplateDir(DOCUMENT_ROOT.'/template_m/');
				$this->setCompileDir(DOCUMENT_ROOT.'/template_m_c/');
	}
	public function setTempDir_admin(){
//				$this->left_delimiter = '{';
//				$this->right_delimiter = '}';
				
				$this->setTemplateDir(DOCUMENT_ROOT.'/admin/template/');
				$this->setCompileDir( DOCUMENT_ROOT.'/admin/template_c/');
	}	
}
?>