<?php

/**
 * Program  : Dreamtimes Controller (调度器)
 * Author   : YinCy
 * Date     : 2016-8-1
 */

defined('PHPOX') or die(header("HTTP/1.1 403 Not Forbidden"));

class DTC
{
	private static $_instance = array();

	public function __construct(){
		//过滤$_GET和$_POST变量
		unset($_ENV,$HTTP_ENV_VARS,$HTTP_POST_VARS,$HTTP_GET_VARS);
		unset($HTTP_POST_FILES,$HTTP_COOKIE_VARS);
		$this->filter($_GET);
		$this->filter($_POST);
		$this->filter($_COOKIE);
	}

  public function appRun()
  {
        $this->sessionWay();
        $this->action($_GET);
  }

	public function sessionWay(){
		    //session -> mySql
       /***** new include_session(); *****/

        //session -> memcached
        session_start();
	}

	private function action( $get ){
		if ( ! isset($get['ctl']) || empty($get['ctl']) )  $get['ctl']='index';
		if ( ! isset($get['ctl']) || empty($get['act']) )  $get['act']='index';
		unset($_POST['ctl']);
		unset($_POST['act']);

		$class_name = trim($get['ctl']);

//  兼容以前版本的目录设置和类的命名规则
// --------------------------------------
		switch ($class_name)
		{
			 	case 'index':
                case 'registerLogin':
                case 'user':
			 	case 'exam':
					$class = $class_name . 'Action';
					break;
				default:
					$class = 'model_'.$class_name;
				break;
		}

			self::instance( $class, $get['act'] );

	}

    /**
     +----------------------------------------------------------
     * 取得对象实例 支持调用类的静态方法
     * 一个参数返回对象实例。二个参数执行该对象的方法，返回值是方法的return值（可为对象实例）
     +----------------------------------------------------------
     * @param string $class 对象类名
     * @param string $method 类的静态方法名
	   +----------------------------------------------------------
     * @return object
     +----------------------------------------------------------
     */
   public static function instance($class,$method='') {
  		//echo "类名：{$class} --方法名：{$method}";
        $identify   =   $class.$method;
        if(!isset(self::$_instance[$identify])) {
            if(class_exists($class, true)){
                $o = new $class();
                if(!empty($method) && method_exists($o,$method))
                    self::$_instance[$identify] = call_user_func_array( array(&$o, $method), array() );
                else
                    self::$_instance[$identify] = $o;
            }else{
                	 echo " 类：$class 不存在！__autoload中程序挂起并显示错误消息。";
            }
        }
        return self::$_instance[$identify];

  }

   /**
     * Registers Autoloader as an SPL autoloader.
     *
     * @param bool $prepend Whether to prepend the autoloader or not.

     * 所有以smarty开始命名的文件！！都会与Smarty3的plugin子目录文件冲突！！

     */
    public static function registerAutoload($prepend = false)
    {

        if (version_compare(phpversion(), '5.3.0', '>=')) {
            spl_autoload_register(array(__CLASS__, 'autoload'), true, $prepend);
        } else {
            spl_autoload_register(array(__CLASS__, 'autoload'));
        }
    }

 /*
 * 自动加载类文件
 *
 * @param string $class_name 类名 edited by Yincy 16-8-1
 */
    private static function autoload($class)
    {
        $filename = $class;
 				if( DEBUG == true ) $GLOBALS['debugMessage'][] = "<br />AutoLoad--class_name: [$filename]";

				if(substr($class,-8)=='Behavior') { // 加载行为

 					$filename = (APP_PATH.'App/Behavior/'.$class.'.class.php');

        } elseif(substr($class,-5)=='Model'){ // 加载模型

            $filename = (APP_PATH.'App/Model/'.$class.'.class.php');

        } elseif(substr($class,-6)=='Action'){ // 加载控制器

            $filename = APP_PATH.'App/Action/'.$class.'.class.php';

				} elseif(substr($class,-7)=='Require'){ // 加载被包含文件 !!  Include与smarty冲突！！

            $filename = APP_PATH.'App/Require/'.$class.'.class.php';

        } elseif(substr($class,0,8)=='include_'){ // 加载旧的公用类

            $filename = APP_PATH.'include/'.substr($class,8).'.php';

      	} elseif(substr($class,0,6)=='model_'){ // 加载旧的Action类

            $filename = APP_PATH.'model/'.substr($class,6).'.php';

        } elseif( strpos( strtolower($class), 'smarty') === 0 ){ // 加载smarty3.1类 所有以smarty开始命名的文件！！

						$filename = SMARTY_SYSPLUGINS_DIR . $class . '.php';

		        if ( !is_file($filename))
		          {
		           $filename =  SMARTY_DIR . 'Smarty.class.php';
		        	}

        } else {  // 没有任何标志的类

        		$filename = APP_PATH.'App/FrameWork/'.$class.'.class.php';
        }


      	if (file_exists($filename)){

						require_once($filename);

				}else {

						if (DEBUG === true) $GLOBALS['debugMessage'][] = "[$filename]--该文件不存在！<br />";
						return '';
				}
		}

	//过滤器
	private function filter(& $array)
	{
		foreach($array as $key=>$value){
			if(!is_array($value)){
				if (!get_magic_quotes_gpc()){
					$array[$key]=htmlspecialchars(addslashes(trim($value)));
				}else {
					$array[$key]=htmlspecialchars(trim($value));
				}
			}else{
				$this->filter($array[$key]);
			}
		}
	}

}