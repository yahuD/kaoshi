<?php
/*if (file_exists('/var/www/html/check_userpower.inc.php'))
	require_once ('/var/www/html/check_userpower.inc.php');
else
	{echo 'file check_userpower.inc.php is not exist!'; die; }
*/
/**
 * Displays : 系统函数
 * Author   : phpox
 * Date     : Sun Nov 08 17:13:58 CST 2009
 */
function GetData($url){
	$contents = file_get_contents($url);
	echo $contents;
}

function PostData($host,$port,$page,$data){
	$sock = fsockopen("$host", $port, $errno, $errstr, 30);
	if (!$sock)
		return "";
	fwrite($sock, "POST $page HTTP/1.0\r\n");
	fwrite($sock, "Host: $host\r\n");
	fwrite($sock, "Content-type: application/x-www-form-urlencoded\r\n");
	fwrite($sock, "Content-length: " . strlen($data) . "\r\n");
	fwrite($sock, "Accept: */*\r\n");
	fwrite($sock, "\r\n");
	fwrite($sock, "$data");
	$headers = "";
	while ($str = trim(fgets($sock, 4096)))
		 $headers .= "$str\n";
	$body = "";
	while (!feof($sock))
		 $body .= fgets($sock, 4096);
	fclose($sock);
	return $body;
}

function short_message($number,$txt){
	$num        = substr_count($number,',');
	$num        +=1;
	$url        = 'www.qf106.com';
	$userid     = '9227';
	$account    = '尹闯';
	$password   = '123456';
	$mobile     = $number;
	$content    = $txt;
	$sendTime   = '';
	$action     = 'send';
	$checkcontent   = '0';
	$taskName       = '';
	$countnumber    = $num;
	$mobilenumber   = $num;
	$telephonenumber= 0;

	$data       = "userid=$userid&account=$account&password=$password&mobile=$mobile&content=$content&sendTime=$sendTime&action=$action&checkcontent=$checkcontent&taskName=$taskName&countnumber=$countnumber&mobilenumber=$mobilenumber&telephonenumber=$telephonenumber";
	$result     = PostData($url,80,'/sms.aspx',$data);
	$xml        = @simplexml_load_string($result);
	if ($xml && isset($xml->returnstatus)){
		$status     = (string)$xml->returnstatus;
		$message    = (string)$xml->message;
		$remainpoint= (string)$xml->remainpoint;

		$fileanme   = 'short_message_log.txt';
		if(file_exists($fileanme)===false)  mkdir($fileanme,0777,true);
		$file = fopen('short_message_log.txt', "w+");
		fwrite($file,date('Y_m_d_H_i_s').'->'.$data.'->['.$status.']->['.$message.']->['.$remainpoint.']'."\r\n");
		fclose($file);

		if($status=='Success')
			return true;
		else
			return false;
	}
	else
		return false;
}

defined('PHPOX') or die(header("HTTP/1.1 403 Not Forbidden"));

function formatpay($pay){
	return number_format($pay, 2,'.','');
}

function plog($msg){
	file_put_contents('log.txt',$msg);
}

function log_result($word){
	$fp = fopen("alipay_log.txt","a");
	flock($fp, LOCK_EX) ;
	fwrite($fp,$word."：执行日期：".strftime("%Y%m%d%H%I%S",time())."\t\n");
	flock($fp, LOCK_UN);
	fclose($fp);
}
function getcartgiftnum(){
	if( !isset($_COOKIE['gifts'])) return 0;
	$gifts = unserialize(stripslashes(htmlspecialchars_decode($_COOKIE['gifts'])));
	$num = 0;
	if(is_array($gifts) && !empty($gifts)){
		foreach ($gifts as $arr){
			$num += $arr['num'];
		}
	}
	return $num;
}
/*  ---- 用下面新的函数替代 ------- Edited yincy 17-8-28*/
function getcartshopnum(){

	$num = 0;
	if( !isset($_COOKIE['cart'])) return 0;
	$cookieStr = stripslashes(htmlspecialchars_decode($_COOKIE['cart']));
	list( $c, $q) = explode("&", $cookieStr);
	list( ,$cStr ) = explode("=", $c );
	$commIDs = explode(",", $cStr);
	return count($commIDs);
}

function getgifts(){
	if( !isset($_COOKIE['gifts'])) return '';
	$gifts = unserialize(stripslashes(htmlspecialchars_decode($_COOKIE['gifts'])));
	return $gifts;
}

function getshops()
{
	$shops = array();
	$cookieStr = stripslashes(htmlspecialchars_decode($_COOKIE['cart']));
	if( empty($cookieStr)) return $shops;
	list( $c, $q) = explode("&", $cookieStr);
	list( ,$cStr ) = explode("=", $c );
	list( ,$qStr ) = explode("=", $q);
	$commIDs = explode(",", $cStr);
	$qtys        = explode(",", $qStr);
	for ($i=0; $i<count($commIDs); $i++ ){
		$shops[ $commIDs[$i] ] = array ( 'num' => (int)$qtys[$i] );
	}
	return $shops;
}


function getdiscount(){
	$quotiety = include('include/footer_quotiety.php');
	$typeid = $_SESSION['userdetail']['typeid'];
	$roleid = $_SESSION['userdetail']['roleid'];
	$discount = $quotiety[$typeid][$roleid];
	if ($discount == 0) $discount = 1;
	return (float)$discount;
}
function discount(&$a){
	foreach ($a as $k => $v){
		$a[$k] = $v/10;
	}
	return $a;
}
function undiscount(&$a){
	foreach ($a as $k => $v){
		$a[$k] = $v*10;
	}
	return $a;
}
function checklogin(){
	if (!getUid()){
		alertinfo('请先登录!',url('user','login'));
	}
}

function checkadmin(){
	if (!isadmin()){
		alertinfo('你没有权限!','index.php');
	}
}
function phprpccheckadmin(){
	if($_SESSION['userdetail']['typeid'] != '4'){
		return false;
	}
}

function isadmin(){
	if($_SESSION['userdetail']['typeid'] == 4)return true;
	else return false;
}
function isbbsadmin(){
	return check_userpower2('1,3');
}
function islogin(){
	if( isset($_SESSION['userdetail']) || empty($_SESSION['userdetail'])) return false;
	else return true;
}
function getUid(){
	return $_SESSION['userdetail']['uid'];
}
function getTaobao(){
	return  isset($_SESSION['taobaouser']['user_id']) ? $_SESSION['taobaouser']['user_id']:'';
}
function getUsername(){
	return $_SESSION['userdetail']['nickname'];
}
function getUserInfo(){
	return isset($_SESSION['userdetail']) ? $_SESSION['userdetail'] : '';
}

/**
 * 生成checkbox的选项
 * @param array $arr 默认被选中的数组
 * @param array $all 全部选项数组
 * @param array $info input 的附加属性
 * @param string $sp 每个选项之间的分隔符
 */
function setCheckBox($arr,$all,$info,$sp=' '){
	$str = "<input type='checkbox'";
	foreach($info as $k=>$v){
		$str .= " $k='$v'";
	}
	$code = '';
	foreach($all as $k=>$v){
		if(is_array($arr) && in_array($k,$arr)){
			$code .= $str." value='$k' checked />$v".$sp;
		} else {
			$code .= $str." value='$k' />$v".$sp;
		}
	}
	return $code;
}

/**
 * 生成SELECT的选项
 *
 * @param string $selected 默认选中的值
 * @param array $all 选项数组
 * @return string
 */
function setOption($selected,$all)   {
	$code = '';
	if (!is_array($all) || empty($all)) return '';
	foreach($all as $k=>$v){
		if($k == $selected)   {
			$code .= "<option value='$k' selected>$v</option>\n";
		}else{
			$code .= "<option value='$k'>$v</option>\n";
		}
	}
	return $code;
}

/**
 * 计算时间差
 *
 * @param char $interval 返回的格式
 * @param datetime $dateTimeBegin 开始时间
 * @param datetime $dateTimeEnd 结束时间
 * @return int
 */
function dateDiff($interval,$dateTimeBegin,$dateTimeEnd){
	$dateTimeBegin = strtotime($dateTimeBegin);
	if($dateTimeBegin === -1){
		return("begin date Invalid");
	}
	$dateTimeEnd = strtotime($dateTimeEnd);
	if($dateTimeEnd === -1){
		return("end date Invalid");
	}
	$dif = $dateTimeEnd - $dateTimeBegin;
	switch($interval){
		case "s"://seconds
			return($dif);
		case "n"://minutes
			return(floor($dif/60)); //60s=1m
		case "h"://hours
			return(floor($dif/3600)); //3600s=1h
		case "d"://days
			return(floor($dif/86400)); //86400s=1d
	}
}

function psetcookie($name,$value,$expires){
	return setcookie($name,$value,$expires,'/');
}

/**
 * 递归处理数组
 *
 * @param array $array 要被处理的数组
 */
function filter(& $array){
	foreach($array as $key=>$value){
		if(!is_array($value)){
			if (!get_magic_quotes_gpc()){
				$array[$key] = htmlspecialchars(addslashes(trim($value)));
			}else {
				$array[$key] = htmlspecialchars(trim($value));
			}
		}else{
			filter($array[$key]);
		}
	}
}

/**
 * 解析JS中escape后的字符串
 *
 * @param string $str
 * @return string
 */
function unescape($str) {
	$str = rawurldecode($str);
	preg_match_all("/%u.{4}|&#x.{4};|&#d+;|.+/U",$str,$r);
	$ar = $r[0];
	foreach($ar as $k=>$v){
		if(substr($v,0,2) == "%u"){
			$ar[$k] = iconv("UCS-2","GBK",pack("H4",substr($v,-4)));
		}elseif(substr($v,0,3) == "&#x"){
			$ar[$k] = iconv("UCS-2","GBK",pack("H4",substr($v,3,-1)));
		}elseif(substr($v,0,2) == "&#"){
			$ar[$k] = iconv("UCS-2","GBK",pack("n",substr($v,2,-1)));
		}
	}
	return join("",$ar);
}

/**
 * 回调函数反转义Html标签
 */
function array_hscd(&$item1, $key){
	$item1 = htmlspecialchars_decode($item1);
}

/**
 * 从一个二维数组中返回指定键值的数组
 *
 * @param array $arr
 * @param string $key
 * @param string $value
 *
 * @return array
 */
function array_key_values(& $arr, $key, $value){
	$ret = array();
	foreach ($arr as $row){
		if (isset($row[$key]) && $row[$key] == $value){
			return $row;
		}
	}
}

function array_key_values2(& $arr, $key, $value){
	$ret = array();
	foreach ($arr as $row){
		if (isset($row[$key]) && $row[$key] == $value){
			$ret[] = $row;
		}
	}
	return $ret;
}

/**
 * 从一个二维数组中返回指定键的所有值
 *
 * @param array $arr
 * @param string $col
 *
 * @return array
 */
function array_col_values(& $arr, $col){
	$ret = array();
	foreach ($arr as $row) {
		if (isset($row[$col])) { $ret[] = $row[$col]; }
	}
	return $ret;
}

/**
 * 返回指定对象的唯一实例
 *
 * @param string $className
 *
 * @return object
 */
function & getSingleton($className){
	static $instances = array();
	if (isRegistered($className)) {
		// 返回已经存在的对象实例
		return registry($className);
	}
	$classExists = class_exists($className);
	if (!$classExists){
		return false;
	}
	$instances[$className] = new $className();
	register($instances[$className], $className);
	return $instances[$className];
}

/**
 * 将一个对象实例注册到对象实例容器
 *
 * @param object $obj
 * @param string $name
 *
 * @return object
 */
function & register(& $obj, $name = null){
	if (!is_object($obj)){
		return false;
	}
	if (is_null($name)){
		$name = get_class($obj);
	}
	if (isset($GLOBALS[G_PHPOX_VAR]['OBJECTS'][$name])) {
		return false;
	} else {
		$GLOBALS[G_PHPOX_VAR]['OBJECTS'][$name] = $obj;
		return $obj;
	}
}

/**
 * 从对象实例容其中取出指定名字的对象实例，如果没有指定名字则返回包含所有对象的数组
 *
 * @param string $name
 *
 * @return object
 */
function & registry($name = null){
	if (is_null($name)) {
		return $GLOBALS[G_PHPOX_VAR]['OBJECTS'];
	}
	if (isset($GLOBALS[G_PHPOX_VAR]['OBJECTS'][$name]) && is_object($GLOBALS[G_PHPOX_VAR]['OBJECTS'][$name])) {
		return $GLOBALS[G_PHPOX_VAR]['OBJECTS'][$name];
	}
	return false;
}

/**
 * 检查指定名字的对象是否已经注册
 *
 * @param string $name
 *
 * @return boolean
 */
function isRegistered($name){
	return isset($GLOBALS[G_PHPOX_VAR]['OBJECTS'][$name]);
}

/**
  * 解密字符串
  *
  * @param string $string 要加密或解密的字符串
  * @param string $key 解密时用的KEY
  * @return string 解密后的字符串
  *
  */
function authdecode($string,$key = ''){

	$key = md5($key ? $key : 'PHPOX');//如果有$key则md5加密$key,否则md5加密PHPOX
	$key_length = strlen($key); //加密后key的长度

	/*
	*如果$operation等于DECODE则用base64_decode解密$string并赋给$string
	*否则md5加密$string+$key,并取前8个字符在加上$string再赋给$string
	*/
	$string =  base64_decode($string);
	$string_length = strlen($string);//计算$string的长度

	$rndkey = $box = array(); //初始化2个数组
	$result = ''; //初始化一个字符串

	/*
	*循环255次
	*用$rndkey保存$key的ASCII码
	*用$box保存$i
	*/
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($key[$i % $key_length]);
		$box[$i] = $i;
	}


	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if(substr($result, 0, 8) == substr(md5(substr($result, 8).$key), 0, 8)) {
		return substr($result, 8);
	} else {
		return '';
	}
}

/**
 * 取出指定名字的设置值
 *
 * @param string $option 选项名字
 * @param string $default 如果没有的默认值
 * @return string
 */
function getAppInf($option, $default = null){
	return isset($GLOBALS[G_PHPOX_VAR]['APP_INF'][$option]) ?
	$GLOBALS[G_PHPOX_VAR]['APP_INF'][$option] :
	$default;
}

/**
 * 获得指定名字的设置值中的项目，要求该设置必须是数组
 *
 * @param string $option 选项名字
 * @param string $keyname 选项的KEY
 * @param string $default 如果没找到的默认值
 * @return array
 */
function getAppInfValue($option, $keyname, $default = null){
	return isset($GLOBALS[G_PHPOX_VAR]['APP_INF'][$option][$keyname]) ?
	$GLOBALS[G_PHPOX_VAR]['APP_INF'][$option][$keyname] :
	$default;
}

/**
 * 修改设置值
 *
 * @param string $option 配置选项
 * @param string $data 选项的值
 */
function setAppInf($option, $data = null){
	if (is_array($option)) {
		$GLOBALS[G_PHPOX_VAR]['APP_INF'] = array_merge($GLOBALS[G_PHPOX_VAR]['APP_INF'], $option);
	} else {
		$GLOBALS[G_PHPOX_VAR]['APP_INF'][$option] = $data;
	}
}

/**
 * 构造 伪静态url
 *
 * @param string $ctl 控制器名字
 * @param string $act 动作名
 * @param array $params 附加参数数组
 * @return string
 */
function url($ctl = null, $act = null, $params = null) {

	if ($ctl == '') {
		$ctl = 'index';
	}

	if ($act == '') {
		$act = 'index';
	}

	//$url = 'http://'.$_SERVER['HTTP_HOST'];
	$url = $_SERVER['SCRIPT_NAME'];

	if ($ctl == 'index' && $act == 'index'){
																						return 'index.html';
	}

	$url .= '?ctl=' . $ctl;
	$url .= '&act=' . $act;


	if (is_array($params) && !empty($params)) {
		$url .= '&' . encode_url_args($params);
	}

	// typeNN/proNN 已用新版commodity类代替(已废弃) xy 2018/2/24 17:46:38
	if( $ctl=='shop' && $act=='view' ){
		$classid = intval($params['classid']);
		$url= '/type' . $classid . '/pro' . $params['shopid'] . '.html';
	}

	// typeNN 列表页 已用新版commodity类代替(已废弃) xy 2018/2/24 17:46:38
	if($ctl=='shop' && $act=='lists')
	{
			$classid=   intval($params['classid']);
			$cid        =   intval($params['cid']);
			$p          =   intval($params['p']);

		if ( empty($cid) )  $url= '/type'.$classid.'/';
		else
		{
			if( empty($p) )     $url= '/type'.$classid.'/list'.$cid.'.html';
			else                        $url= '/type'.$classid.'/list'.$cid.'_'.$p.'.html';
		}

		return $url;
	}

	// /effect/ 已用新版commodity类代替(已废弃) xy 2018/2/24 17:46:38
	if( $ctl=='shop' && $act=='effect' )
	{
		$cid        =intval($params['cid']);
		$p          =intval($params['p']);

		if( empty($cid) )       $url='/effect/';
		else{
			if(empty($p))           $url= '/effect/list'.$cid.'.html';
			else                            $url= '/effect/list'.$cid.'_'.$p.'.html';
		}
		return $url;
	}


		// V3版 商品详情
		if($ctl=='commodity' && $act=='view'){

			// m2 q1 老产品
			//if(isset($params['comm_id']) && (int)$params['comm_id'] <= 64 ){//64
			if(isset($params['comm_id'])){
				$classid = intval($params['departmentId']);
				$url= '/type' . $classid . '/pro' . $params['comm_id'] . '.html';

			// m3 k2 新产品
			}else{
				//$url = empty($params['urlname'])? "/index.html":$params['urlname'];//$params['urlname']为空，应返回404
			}

		}

	// V3版 /department-m2-idNN/category-skin_milk-idNN/ 列表页
	if($ctl=='commodity' && $act=='lists')
	{
		$url = '/department-m2-id2/'; //daault url

				// m2 q1 老产品url
				//if (isset($params['departmentId']) && (int)$params['departmentId'] <= 6 ){
				if (isset($params['departmentId'])){
					$classid=   intval($params['departmentId']);
					$cid        =   intval($params['categoryId']);
					$p          =   intval($params['p']); //page

					if ( empty($cid) )  $url= '/type'.$classid.'/';
					else
					{
						if( empty($p) )     $url= '/type'.$classid.'/list'.$cid.'.html';
						else                        $url= '/type'.$classid.'/list'.$cid.'_'.$p.'.html';
					}

			// effect
				} else if (isset($params['departmentId']) && (int)$params['departmentId'] == 12){
					$cid        =intval($params['categoryId']);
						$p          =intval($params['p']); //page

						if( empty($params['categoryId']) )      $url='/effect/';
						else{
							if(empty($p))           $url= '/effect/list'.$cid.'.html';
							else                            $url= '/effect/list'.$cid.'_'.$p.'.html';
						}

				// m3 k2 新产品url
			} else if (isset($params['departmentURLname']) && !empty($params['departmentURLname'] )){
			$url  = "/department-{$params['departmentURLname']}-id{$params['departmentId']}/";

			if (isset($params['categoryURLname']) && !empty($params['categoryURLname'] )){
			   $url .= "category-{$params['categoryURLname']}-id{$params['categoryId']}/";
			   if (isset($params['page']) && !empty($params['page'])) $url .= "page-{$params['page']}/";
			}
		}
	}


	if($ctl=='shop'&& $act=='gifts')
	{
		if( empty($params['p']) )   $url= '/tz/';
		else                                            $url= '/tz/'.$params['p'].'.html';
	}
	if($ctl=='shop'&& $act=='best')
	{
		if( empty($params['p']) )   $url= '/paihang/';
		else                                            $url= '/paihang/'.$params['p'].'.html';
	}



	if( $ctl=='weekly' && $act=='Dweekly_list' )
	{
		if( empty($params['page']) )
		{
				if(empty($params['class']))   return '/news/';
				else                                                    return '/news/lists'.$params['class'].'.html';
		}else{
																			return '/news/lists'.$params['class'].'_'.$params['page'].'.html';
		}
	}


	if( $ctl=='union' && $act=='index' )
	{
			$url= '/join/';
																			return $url;
	}


	if( $ctl=='union' && $act=='faq' )
	{
		$url= '/join/'.$params['sort'].'.html';
																		return $url;
	}


	if( $ctl=='union' && $act=='lists' )
	{
		if( !empty($params['sticky']) )
		{
			if(empty($params['p']))
			{
				if(!empty($params['classid']))
																		return '/club/c'.$params['classid'].'/sticky.html';
				else
																		return '/club/sticky.html';
			}
			else{
				if(!empty($params['classid']))
																		return '/club/c'.$params['classid'].'/sticky_list'.$params['p'].'.html';
				else
																		return '/club/sticky_list'.$params['p'].'.html';
			}

		}else{

			if(empty($params['p']))
			{
				if(!empty($params['classid']))
																		return '/club/c'.$params['classid'].'/';
				else
																		return '/club/';
			}else{
				if(!empty($params['classid']))
																		return '/club/c'.$params['classid'].'/list'.$params['p'].'.html';
				else
																		return '/club/list'.$params['p'].'.html';
			}
		}
	}



	if($ctl=='union'&& $act=='read'){
																		return '/club/p'.$params['bbsid'].'.html';
	}


	if($ctl=='union'&& $act=='newpost'){
																		return '/club/newpost.html';
	}


	if($ctl=='user'&& $act=='bbs')
	{
		if(empty($params['p']))                 return '/user/bbs.html';
		else                                                        return '/user/bbs'.$params['p'].'.html';
	}

	/*if($ctl=='user'&& $act=='myorder'){
		if(empty($params['p']))return '/user/myorder.html';
		else return '/user/myorder'.$params['p'].'.html';
	}
	if($ctl=='user'&& $act=='message'){
		if(empty($params['p']))return 'message.html';
		else return 'message_'.$params['p'].'.html';
	}
	*/


	if($ctl=='user'&& $act=='faq')
	{
		$url         = '/help/';
		$url        .= intval($params['faq']);
		$url        .= '_' . intval($params['sort']) . '.html';

																		return $url;
		//if(!empty($params['faq']))$url= 'faqs_'.$params['sort'].'_faq'.urlencode($params['faq']).'.html';
	}


	if($ctl=='index'&& $act=='aboutus')
	{
		if(empty($params['mtype']))         return '/us/';
		else                                                        return '/us/'.$params['mtype'].'.html';
	}


	if($ctl=='index'&& $act=='lipin')
	{
																		return '/lipin.html';
	}


	if($ctl=='index'&& $act=='mengnvlang')
	{
																		return '/mengnvlang.html';
	}


	if($ctl=='index'&& $act=='lipin_view'){
																		return '/lipin_view.html';
	}

	return $url;
}


/**
 * 将数组转换为可通过 url 传递的字符串连接
 *
 * @param array $args 原数组
 * @return string
 */
function encode_url_args($args) {
	$str = '';
	foreach ($args as $key => $value) {
		$str .= '&' . rawurlencode($key) . '=' . rawurlencode($value);
	}
	return substr($str, 1);
}

/**
 * 将一个二维数组转换为 hashmap
 *
 * @param array $arr 原数组
 * @param string $keyField 做数组KEY的字段名
 * @param string $valueField 做数组VALUE的字段名
 * @return array
 */
function array_to_hashmap(& $arr, $keyField, $valueField = null){
	$ret = array();
	if ($valueField) {
		foreach ($arr as $row) {
			$ret[$row[$keyField]] = $row[$valueField];
		}
	} else {
		foreach ($arr as $row) {
			$ret[$row[$keyField]] = $row;
		}
	}
	return $ret;
}

/**
 * 将一个二维数组按照指定字段的值分组
 *
 * @param array $arr 原数组
 * @param string $keyField 字段名
 * @return array
 */
function array_group_by(& $arr, $keyField){
	$ret = array();
	foreach ($arr as $row) {
		$key = $row[$keyField];
		$ret[$key][] = $row;
	}
	return $ret;
}

/**
 * 将提交过来的日期转成时间戳
 *
 * @param string $prefix smarty日期时间插件的前缀
 * @return int
 */
function getUnixtime($prefix){
	$year = $_POST[$prefix.'Year'];
	$month = $_POST[$prefix.'Month'];
	$day = $_POST[$prefix.'Day'];
	$str = $year.'-'.$month.'-'.$day;
	if (($timestamp = strtotime($str)) === false) {
		return false;
	} else {
		return $timestamp;
	}
}

/**
 * URL跳转
 *
 * @param string $url 要跳转的URL
 * @param int $delay 等待的时间
 */
function redirect($url, $delay = 0) {
	if (headers_sent() || $delay > 0) {
		$delay = (int)$delay;
		echo <<<EOT
<html>
<head>
<meta http-equiv="refresh" content="{$delay};URL={$url}" />
</head>
</html>
EOT;
} else {
	header("Location: {$url}");
}
exit;
}

/**
 * 弹出提示框,并终止程序执行
 *
 * @param string $info 提示的信息
 * @param bool $back 是否后退
 */
function alerterror($info,$back=true){
	$str = "<script type='text/javascript'>alert('$info');";
	if (true === $back){
		$str .= "history.go(-1);";
	}
	$str .= "</script>";
	echo $str;
	exit();
}

/**
 * 弹出提示框,并关闭页面
 *
 * @param string $info 提示的信息
 * @param bool $back 是否后退
 */
function alertexit($info){
	$str =  "<script type='text/javascript'>alert('$info');window.close();";
	$str .=  "</script>";
	echo $str;
	exit();
}

/**
 * 弹出提示信息对话框
 *
 * @param string $info 提示的信息
 * @param string $url 跳转的URL
 * @param string $window 窗口的级别
 */
function alertinfo($info,$url,$window=''){
	if(!empty($info))
		$str = "<script type='text/javascript'>alert('$info');window{$window}.location.href='$url';</script>";
	echo $str;
	exit();
}

/**
 * 显示错误信息
 *
 * @param  int $code 错误代码
 */
function showerror($code){
	echo getAppInfValue('errinfo',$code,'null');
	exit();
}

/**
 * 字符串截取函数
 *
 * @param string $str 原字符串
 * @param int $length 要取得长度 单位:字数
 * @return string
 */
function cut_str($str,$length,$extstr=''){
	$returnstr='';
	$i=0;
	$n=0;
	$str_length=strlen($str);
	while (($n < $length) and ($i <= $str_length)){
		$temp_str=substr($str,$i,1);
		$ascnum=ord($temp_str);
		if ($ascnum>=224){
			$returnstr=$returnstr.substr($str,$i,3);
			$i=$i+3;
			$n++;
		}elseif ($ascnum>=192){
			$returnstr=$returnstr.substr($str,$i,2);
			$i=$i+2;
			$n++;
		}elseif ($ascnum>=65 && $ascnum<=90){
			$returnstr=$returnstr.substr($str,$i,1);
			$i=$i+1;
			$n++;
		}else{
			$returnstr=$returnstr.substr($str,$i,1);
			$i=$i+1;
			$n=$n+0.5;
		}
	}
	if ($str_length/3>$length){
		$returnstr = $returnstr.chr(0).$extstr;
	}else {
		$returnstr = $returnstr.chr(0);
	}
	return $returnstr;
}
function cut_str2($sourcestr,$cutlength)
{
		$returnstr='';
		$i=0;
		$n=0;
		$str_length=strlen($sourcestr);//字符串的字节数
		while (($n<$cutlength) and ($i<=$str_length))
		{
		$temp_str=substr($sourcestr,$i,1);
		$ascnum=Ord($temp_str);//得到字符串中第$i位字符的ascii码
		if ($ascnum>=224) //如果ASCII位高与224，
		{
		$returnstr=$returnstr.substr($sourcestr,$i,3); //根据UTF-8编码规范，将3个连续的字符计为单个字符
		$i=$i+3; //实际Byte计为3
		$n++; //字串长度计1
		}
		elseif ($ascnum>=192) //如果ASCII位高与192，
		{
		$returnstr=$returnstr.substr($sourcestr,$i,2); //根据UTF-8编码规范，将2个连续的字符计为单个字符
		$i=$i+2; //实际Byte计为2
		$n++; //字串长度计1
		}
		elseif ($ascnum>=65 && $ascnum<=90) //如果是大写字母，
		{
		$returnstr=$returnstr.substr($sourcestr,$i,1);
		$i=$i+1; //实际的Byte数仍计1个
		$n++; //但考虑整体美观，大写字母计成一个高位字符
		}
		else //其他情况下，包括小写字母和半角标点符号，
		{
		$returnstr=$returnstr.substr($sourcestr,$i,1);
		$i=$i+1; //实际的Byte数计1个
		$n=$n+0.5; //小写字母和半角标点等与半个高位字符宽...
		}
		}
		if ($str_length>$cutlength){
		$returnstr = $returnstr;//超过长度时在尾处加上省略号
		}
		return $returnstr;
}
/**
 * 获取用户真实 IP
 *
 * @return string
 */
function getIpaddr(){
	static $realip;
	if (isset($_SERVER)){
		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
			$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} else if (isset($_SERVER["HTTP_CLIENT_IP"])){
			$realip = $_SERVER["HTTP_CLIENT_IP"];
		} else {
			$realip = $_SERVER["REMOTE_ADDR"];
		}
	} else {
		if (getenv("HTTP_X_FORWARDED_FOR")){
			$realip = getenv("HTTP_X_FORWARDED_FOR");
		} else if (getenv("HTTP_CLIENT_IP")) {
			$realip = getenv("HTTP_CLIENT_IP");
		} else {
			$realip = getenv("REMOTE_ADDR");
		}
	}
	return $realip;
}

function emailCheck($email)
{
		return preg_match("/^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]$/i",$email);
}

//allnum是记录总数,perpagenum是每页记录数,nowpage是现在的页码,pagetag是翻页get参数名,pagecount是页码范围，用于切换超过10页的显示
function pagebar($url,$allnum,$perpagenum,$nowpage,$type=0,$pagetag='page',$pageround=10,$cssclass='pagelist'){
	$pagenum=ceil($allnum/$perpagenum);//总页数
	$pagenum=$pagenum>0?$pagenum:1;
	$link=strrchr($url,'?')?'&':'?';
	$nowpage=isset($nowpage)?$nowpage:1;
	$pre=1;
	if($allnum<$perpagenum)return '';

	if($type==0){
		$round=ceil($pagenum/$pageround);//轮回数
		$nowround=($nowpage>$pageround)?ceil($nowpage/$pageround):1;
		$str="<ul class='{$cssclass}'><li>共&nbsp;&nbsp;{$pagenum}&nbsp;&nbsp;页</li><li>{$allnum}&nbsp;&nbsp;项</li>";
		$str.="<li><a href='{$url}{$link}{$pagetag}=1'>首页</a></li>";
		if($nowpage>1){
			$pre = 0;
			if($pre>$nowpage*$pageround)$pre=$nowpage-1;
			else $pre=$nowpage-1;
		}else $pre=1;
		$lastpage=($nowpage>1)?($nowpage-1):1;
		if($nowpage>1)$str.="<li><a href='{$url}{$link}{$pagetag}={$lastpage}'>上页</a></li>";
		$next=($nowpage<$allnum )?($nowpage+1):$allnum;

		if($nowround>1){
			$preround=($nowround-1)*$pageround;
			$str.="<li><a href='{$url}{$link}{$pagetag}={$preround}'><<</a></li>";
		}
		$countstart=($nowround>1)?($nowround-1)*$pageround+1:1;
		$countend=($nowround< $round)?($countend+$perpagenum):($pagenum-$countstart+1);
		for($i=$countstart;$i<($countstart+$countend);$i++)
			if($i==$nowpage)$str.="<li>{$i}</li>";
			else $str.="<li><label><a href='{$url}{$link}{$pagetag}={$i}'>{$i}</a></label></li>";
		if($nowround< $round){
			$nextround=($nowround)*$pageround+1;
			$str.="<li><a href='{$url}{$link}{$pagetag}={$nextround}'>>></a></li>";
		}
		$nextpage=($nowpage< $pagenum)?($nowpage+1):$pagenum;
		if($nowpage<$pagenum)$str.="<li><a href='{$url}{$link}{$pagetag}={$next}'>下页</a></li>";
		$str.="<li><a href='{$url}{$link}{$pagetag}={$pagenum}'>末页</a></li></ul>";
	}
	if($type==1){
		$round=ceil($pagenum/$pageround);//轮回数
		$nowround=($nowpage>$pageround)?ceil($nowpage/$pageround):1;
		$str="<ul class='{$cssclass}'><li>共&nbsp;&nbsp;{$pagenum}&nbsp;&nbsp;页</li><li>{$allnum}&nbsp;&nbsp;项</li>";
		$str.="<li><a href='{$url}{$link}{$pagetag}=1'>首页</a></li>";
		if($nowpage>1){
			if($pre>$nowpage*$pageround)$pre=$nowpage-1;
			else $pre=$nowpage-1;
		}else $pre=1;
		$lastpage=($nowpage>1)?($nowpage-1):1;
		if($nowpage>1)$str.="<li><a href='{$url}{$link}{$pagetag}={$lastpage}'>上页</a></li>";
		$next=($nowpage< $allnum)?($nowpage+1):$allnum;


		$countstart=($nowround>1)?($nowround-1)*$pageround+1:1;
		$countend=($nowround< $round)?($countend+$perpagenum):($pagenum-$countstart+1);
		for($i=$countstart;$i<($countstart+$countend);$i++)
			if($i==$nowpage)$str.="<li>{$i}</li>";
			else $str.="<li><label><a href='{$url}{$link}{$pagetag}={$i}'>{$i}</a></label></li>";
		$nextpage=($nowpage< $pagenum)?($nowpage+1):$pagenum;
		if($nowpage<$pagenum)$str.="<li><a href='{$url}{$link}{$pagetag}={$next}'>下页</a></li>";
		$str.="<li><a href='{$url}{$link}{$pagetag}={$pagenum}'>末页</a></li>";
		$str.="<li>&nbsp;&nbsp;选择&nbsp;&nbsp;</li>";
		$str.="<li><span><select onChange=\"window.location='{$url}{$link}{$pagetag}='+this.options[this.options.selectedIndex].value;\">";
		$start=1;
		for($i=1;$i<=$round;$i++ )
		{
			$countstart=($i>1)?($i-1)*$pageround+1:1;
			$countend=($i<$round)?($countstart+$perpagenum-1):$pagenum;
			$str.= "<option value='{$countstart}'";
			if(($nowpage>=$countstart)&&($nowpage<=$countend))$str.=' selected';
			$str.=">第{$countstart}到{$countend}页</option>" ;
		}
		$str.='</select></span></li></ul>';
	}
	if($type==3){
		$round=ceil($pagenum/$pageround);//轮回数
		$nowround=($nowpage>$pageround)?ceil($nowpage/$pageround):1;
		$str="<ul class='{$cssclass}'><li>共&nbsp;&nbsp;{$pagenum}&nbsp;&nbsp;页</li><li>{$allnum}&nbsp;&nbsp;项</li><li>每页 {$perpagenum} 条</li>";
		if($nowpage>1){
			$pre = 0;
			if($pre>$nowpage*$pageround)$pre=$nowpage-1;
			else $pre=$nowpage-1;
		}else $pre=1;
		$lastpage=($nowpage>1)?($nowpage-1):1;
		//if($nowpage>1)
			$str.="<li><a href='{$url}{$link}{$pagetag}={$lastpage}'>上一页</a></li>";
		$next=($nowpage<$allnum)?($nowpage+1):$allnum;

		if($nowround>1){
			$preround=($nowround-1)*$pageround;
			$str.="<li><a href='{$url}{$link}{$pagetag}={$preround}'><<</a></li>";
		}
		$countstart=($nowround>1)?($nowround-1)*$pageround+1:1;
		$countend=($nowround<$round)?($countend+$perpagenum):($pagenum-$countstart+1);
		for($i=$countstart;$i<($countstart+$countend);$i++)
			if($i==$nowpage)$str.="<li class=\"weekly_page_selected\">{$i}</li>";
			else $str.="<li><label><a href='{$url}{$link}{$pagetag}={$i}'>{$i}</a></label></li>";
		if($nowround<$round){
			$nextround=($nowround)*$pageround+1;
			$str.="<li><a href='{$url}{$link}{$pagetag}={$nextround}'>>></a></li>";
		}
		$nextpage=($nowpage<$pagenum)?($nowpage+1):$pagenum;
		//if($nowpage<$pagenum)
			$str.="<li><a href='{$url}{$link}{$pagetag}={$next}'>下一页</a></li>";
	}
	echo $type;
	return $str;
}
function cutstr($string, $length,$charset='utf-8',$dot = ' ...') {

	if(strlen($string) <= $length) {
		return $string;
	}

	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);

	$strcut = '';
	if(strtolower($charset) == 'utf-8') {

		$n = $tn = $noc = 0;
		while($n < strlen($string)) {

			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t <= 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}

			if($noc >= $length) {
				break;
			}

		}
		if($noc > $length) {
			$n -= $tn;
		}

		$strcut = substr($string, 0, $n);

	} else {
		for($i = 0; $i < $length; $i++) {
			$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}

	$strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

	return $strcut.$dot;
}
function bbcode($str){
	$text = preg_replace("/\[em:(.+?):]/is","<img src=\"admin/js/ubb/faceall/$1.gif\" class=\"face\">",$str);   $text = preg_replace("/\[em:(.+?):]/is","<img src=\"js/ubb/faceall/$1.gif\" class=\"face\">",$str);
	return $text;
}
function getFileExt($filename) {
	if (substr_count($filename, ".") == 0) return;
	else if (substr($filename, -1) == ".") return;
	else return strtolower(substr(strrchr ($filename, "."), 1));
}
function uploadFile($filename,$destdir,$from='',$to='',$changename=false){
	$arr=array();
	if(!empty($from)&&!empty($to)){
		$filename=function_exists('iconv')?iconv($from,$to,$filename):$filename;
		$destdir=function_exists('iconv')?iconv($from,$to,$destdir):$destdir;
	}
	if(!is_dir($destdir)||!is_writable($destdir))return false;
	if(is_array($_FILES[$filename])){
		$count=count($_FILES[$filename]['name']);
		if($count>1){
			for($i=0;$i<$count;$i++){
				if(!empty($_FILES[$filename]['name'][$i])){
					$temp['name']=$_FILES[$filename]['name'][$i];
					if($changename)
						$savename=md5(microtime()+mt_rand(1,10000)).'.'.getFileExt($temp['name']);
					else $savename=$temp['name'];
					$todir=str_replace('\\','/',$destdir.'/'.$savename);
					if(@is_uploaded_file($_FILES[$filename]['tmp_name'][$i]))
					{
						if(@move_uploaded_file($_FILES[$filename]['tmp_name'][$i],$todir))
						{
							$temp['savename']=$savename;
							$temp['size']=sizeCount($_FILES[$filename]['size'][$i]);
							$arr[]=$temp;
						}
					}
				}
			}
		}
		else{
				$temp['name']=$_FILES[$filename]['name'];
				$savename=md5(microtime()+mt_rand(1,10000)).'.'.getFileExt($temp['name']);
				$todir=str_replace('\\','/',$destdir.'/'.$savename);
				if(@is_uploaded_file($_FILES[$filename]['tmp_name']))
				{
					if(@move_uploaded_file($_FILES[$filename]['tmp_name'],$todir))
					{
						$temp['savename']=$savename;
						$temp['size']=sizeCount($_FILES[$filename]['size']);
						$arr[]=$temp;
					}
				}
		}
	}
	return $arr;
}
function mb_unserialize($serial_str) {
	$serial_str= preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );
	$serial_str= str_replace("\r", "", $serial_str);
	return unserialize($serial_str);
}
function json($arr){
	return json_encode($arr);
}
function log_visitor(){
	if($_SESSION['log_visitor']===1) return;
	$_SESSION['log_visitor']    = 1;
	$ip     = getIpaddr();
	if ($ip=="") return;
	$db     = include_database::getInstance();
	$sql    = 'SELECT count(id) as num FROM '.DB_PREFIX.'visitors WHERE '.DB_PREFIX.'visitors.ip = '."'$ip' AND addtime > ".strtotime('-6 hours',time());
	$rs     = $db->doSql($sql);
	if($rs[0]['num']==0){
		$sql    = "INSERT INTO ".DB_PREFIX."visitors set addtime=".time().",ip='$ip'";
		$rs     = $db->execute($sql);
	}
}



//经销商按订单金额分段折扣率
	function getDealerDscntRateByAmount($dscntRateFirst,$variableAmount,$fixedAmount){
		if(empty($_SESSION['userdetail'])) return 1;
		$typeid = $_SESSION['userdetail']['typeid'];
		$roleid = $_SESSION['userdetail']['roleid'];
		if(!in_array($typeid,getAppInf('wholesaletype'))) return $dscntRateFirst;

		$wholeSaleDiscount  = getAppInf('wholesalediscount');
		//$amountAftFirst           = $orderAmount*$dscntRateFirst;
		$dscntRate = 1;

		for($i = count($wholeSaleDiscount)-1; $i>=0; $i-- ){
			//可变金额*折扣系数+固定金额打不大于阶梯金额
			 if( ($variableAmount * $wholeSaleDiscount[$i]['rebate'] + $fixedAmount) >= (float)$wholeSaleDiscount[$i]['amount'] )
					return ($dscntRateFirst < $wholeSaleDiscount[$i]['rebate'])
								? $dscntRateFirst : $wholeSaleDiscount[$i]['rebate'];
		}
		return $dscntRateFirst;
	}

function tranTime($time) {
	$rtime = date("Y-m-d H:i",$time);
	$time = time() - $time;
	if ($time < 60 * 60) {
		$min = floor($time/60);
		$str = $min.'分钟前';
	}
	elseif ($time < 60 * 60 * 24) {
		$h = floor($time/(60*60));
		$str = $h.'小时前 ';
	}
	elseif ($time > 60 * 60 * 24 && $time < 60 * 60 * 2400) {
		$d = floor($time/(60*60*24));
		$str = $d.'天前 ';
	}
	else {
		$str = '大于30天前';
	}
	return $str;
}

//会员VIP升级（按已发货订单金额总计）
function vipupdate( $uid ){
	$db  = include_database::getInstance();

	$sql = "SELECT * FROM ".DB_PREFIX."member where uid='{$uid}' ";
	$userdetail = $db->doSql($sql,true);

	$levels = getAppInf('vipline'); //2维数组
	$myLevels       = $levels[$userdetail['typeid']];

	if( !is_array($myLevels) || count($myLevels)==0 ) return;
	if( empty($userdetail) || $userdetail['locked']==1 ) return; //锁定的会员
	if( !$levels[$userdetail['typeid']] ) return;  //typeid不能VIP升级的，如管理员等

	//已发货订单金额总计
	$sql    = 'SELECT SUM(factpay) as TotalAmount FROM '.DB_PREFIX.'order WHERE uid='.$uid.' AND status = 4';
	$order  = $db->doSql($sql,true);

	$myTotalAmount  = empty($order) ? 0 : intval($order['TotalAmount']);


	//逐级判断是否达到vip等级
	$vip = $i=count($myLevels)-1;
	while($myTotalAmount < $myLevels[$i--]) $vip  = $i;
	/*$vip  = 0;
	for($i=count($myLevels)-1; $i>=0; $i--){
		if($myTotalAmount >= $myLevels[$i]){
			$vip    = $i;
			break;
		}
	}*/

	//更新VIP
	if( $vip != $userdetail['roleid'] ){
		$sql    = "update ".DB_PREFIX."member  set roleid={$vip} where uid={$uid}";
		$db->execute($sql);
		if( isset($_SESSION['userdetail']) && $_SESSION['userdetail']['uid'] == $uid)
			$_SESSION['userdetail']['roleid'] = $vip;

	}
}
function is_mobile() {
	$mobile = array();
	static $mobilebrowser_list ='iPhone|iPad|Android|WAP|NetFront|JAVA|OperasMini|UCWEB|WindowssCE|Symbian|Series|webOS|SonyEricsson|Sony|BlackBerry|Cellphone|dopod|Nokia|samsung|PalmSource|Xphone|Xda|Smartphone|PIEPlus|MEIZU|MIDP|CLDC|PlayBook|KFAPWI|KFTHWI';
	
	if(preg_match("/$mobilebrowser_list/i", $_SERVER['HTTP_USER_AGENT'], $mobile)) {
	   return true;
	}else{
		if(preg_match('/(mozilla|chrome|safari|opera|m3gate|winwap|openwave)/i', $_SERVER['HTTP_USER_AGENT'])) {
			return false;
		}else{
			if($_GET['mobile'] === 'yes') {
				return true;
			}else{
				return false;
			}
		}
	}
}
function is_wx() {
	if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger') !== false ) {
		return true;
	}else{
		return false;
	}
}
function hashencode($string){
	return strtolower(md5("kp_".$string."teacher"));
}
function getRandChar($length){
	$str    = null;
	$strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
	$max    = strlen($strPol)-1;

	for($i=0;$i<$length;$i++){
		$str.=$strPol[rand(0,$max)];
	}

	return $str;
}

//Ajax Json数据传输时程序运行错误捕捉，避免导致Json接收数据出错
function _shutdown_catch_error_JSON()
{
	$_error=error_get_last();
	if($_error && in_array($_error['type'],array(1,4,16,64,256,4096,E_ALL)))
	{
		$message = '<Error> 服务端错误:'.$_error['message'].'</br> 文件:'.$_error['file'].'</br>在第'.$_error['line'].'行</br>';
				$toClient = array( 'lastInsertId' => -1, 'message' => $message );
		echo json_encode( $toClient, JSON_UNESCAPED_UNICODE);
	}
}

/**
 * [getTimestampAfterManyDays 获取多少天后的时间戳]
 * @param  [type] $day [天数]
 * @return [type]      [时间戳]
 */
function getTimestampAfterManyDays( $day ){
	$day = (int)$day;
	$timestamp = strtotime(date("Y-m-d",strtotime("+{$day} days")));
	return $timestamp;
}



function check_userpower($power='',$msg='',$ctl='',$act=''){
//  $ip             = getIpaddr();
//  if($ip!='127.0.0.1' && strstr($ip,'192.168')===false){
//      $ua             = $_SERVER['HTTP_USER_AGENT'];
//      if(strstr($ua,'Customized By SNOW')===false){
//          alertinfo(NULL,'');
//          //echo 'UA_ERR:';
//          //die;
//      }
//  }
	$ip = getIpaddr();
	require_once DOCUMENT_ROOT.'/include/ipaddress/ip.class.php';
	$ipadress   = IP::find($ip);
	//var_export($ipadress);die;
	if(is_array($ipadress) && count($ipadress)>0){
		$country    = $ipadress[0];
		$province   = $ipadress[1];
		$city       = $ipadress[2];
		$area       = $ipadress[3];
		if($country!='本机地址'){
			$admin_allow_ip = getAppInf('admin_allow_ip');
			if(!empty($admin_allow_ip) && !in_array($city,$admin_allow_ip)){
				alertinfo('IP地址不对','/');
				//echo 'IP_ERR:'.$city.' NOT IN('.implode(",",$admin_allow_ip).')';
				//die;
			}
		}
	}
	$class          = isset($ctl)&&!empty($ctl)?$ctl:$_GET['ctl'];
	$method         = isset($act)&&!empty($act)?$act:$_GET['act'];
	//echo $class.'->'.$method.'->';
	$power_table    = getAppInf('power_table');
	if($power_table[$class]){
		if(is_string($power_table[$class]))
			$power  = $power_table[$class];
		elseif($power_table[$class][$method])
			$power  = $power_table[$class][$method];
	}
	//echo $power;die;
	return check_userpower2($power,$msg);
}
function check_userpower2($power,$msg=''){                      //edited by yincy 16-09-28
	if(!empty($_SESSION['userdetail'])){
		$typeid = $_SESSION['userdetail']['typeid'];
		$roleid = $_SESSION['userdetail']['roleid'];
		$power  = explode(',',$power);
		if($typeid==4){
			if($roleid==0)
				return true;
			for($i = 0; $i <= count($power); $i++) {
				if($power[$i]==$roleid)
					return true;
			}
		}
	}
	if($msg)
		alertinfo($msg,'/');
	else
		return false;
}

//xml格式转数组
function xmlToArray($xml){

 //禁止引用外部xml实体

	libxml_disable_entity_loader(true);

	$xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

	$val = json_decode(json_encode($xmlstring),true);

	return $val;

}

//取字符串中数字
function findNum($str=''){
	$str=trim($str);
	if(empty($str)){return '';}
	$temp=array('1','2','3','4','5','6','7','8','9','0');
	$result='';
	for($i=0;$i<strlen($str);$i++){
		if(in_array($str[$i],$temp)){
			$result.=$str[$i];
		}
	}
	return $result;
}
