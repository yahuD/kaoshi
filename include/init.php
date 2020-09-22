<?php

/**
 * Displays : 初始化类
 * Author   : Yincy
 * Date     : Sun Nov 08 17:55:25 CST 2016
 */

class include_init
{
	protected $db;
	protected $smarty;
	protected static $p_data;
	protected static $hasdata=0;

	protected function __construct(){
        $this->db       = DTC::instance('include_database');
		$this->smarty = DTC::instance('dtsmarty3');
	}

  protected function isAjax() {
      if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
          if('xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH']))
              return true;
      }
      if( isset($_POST['AJAXREQUEST']) || isset($_GET['AJAXREQUEST']))
          // 判断Ajax方式提交
          return true;
      return false;
  }

    /**
     +----------------------------------------------------------
     * 模板变量赋值
     +----------------------------------------------------------
     * @param mixed $name 要显示的模板变量
     * @param mixed $value 变量的值
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    protected function assign($name,$value='') {
        $this->view->assign($name,$value);
    }

    public function __set($name,$value) {
        $this->view->assign($name,$value);
    }

    /**
     +----------------------------------------------------------
     * 取得模板显示变量的值
     +----------------------------------------------------------
     * @access protected
     +----------------------------------------------------------
     * @param string $name 模板显示变量
     +----------------------------------------------------------
     * @return mixed
     +----------------------------------------------------------

    public function __get($name) {
        return $this->view->get($name);
    }
*/
    /*
     +----------------------------------------------------------
     * 魔术方法 有不存在的操作的时候执行
     +----------------------------------------------------------

    public function __call($method,$args) {

            if(method_exists($this,'_empty')) {
                // 如果定义了_empty操作 则调用
                $this->_empty($method,$args);
            }elseif(file_exists_case(C('TEMPLATE_NAME'))){
                // 检查是否存在默认模版 如果有直接输出模版
                $this->display();
            }elseif(function_exists('__hack_action')) {
                // hack 方式定义扩展操作
                __hack_action();
            }elseif(APP_DEBUG) {
                // 抛出异常
                throw_exception(L('_ERROR_ACTION_').ACTION_NAME);
            }else{
                if(C('LOG_EXCEPTION_RECORD')) Log::write(L('_ERROR_ACTION_').ACTION_NAME);
                send_http_status(404);
                exit;
            }

            return ;

    }
*/
 /*
     +----------------------------------------------------------
     * 将产品放入内存，并以shopid为索引
     +----------------------------------------------------------
     */
	

	//sql查询结果输出到表格 zht 170106
	public function printArr( $arr=array(), $id='' ){

			if( empty($arr) ) {$table = '<table><tr><td>没有数据</td></tr></table>'; goto printArrEnd;}

	    $i = 0;
	    $id = empty($id)? '' : 'id="'.$id.'"';
	    $table= "<table {$id} class='table table-bordered' style='border-color: #efefef;' border='1px' cellpadding='10px' cellspacing='0px'>";
	    foreach ($arr as $row)
	    {
	        if ($i==0){
            $title = array_keys($row);
            $table.= '<tr>';
            foreach ($title as $v ){$table.= "<th style='padding:5px;'>$v</th>"; }
            $table.= "</tr>";
	        }
	        $table.= "<tr>";
	        foreach ($row as $r){
	          $table.= "<td  style='padding:5px;'>$r</td>";
	        }
	        $table.= "</tr>";
	        $table.= "\n\n";
	        $i++;
	    }
	    $table.= "</table>";
	printArrEnd:
	    echo $table;

	}
	//用户SESSION初始化
	protected function init_session(){
		if(!empty($_SESSION['verification'])){//12小时mobile验证码失效
			if ((time() - $_SESSION['verification']['lasttime']) > 43200) {//12小时
    		//验证码失效
    		unset($_SESSION['verification']);
			}
		}
	}

    //发送短信ip，端口session初始化
    protected function sms_session(){
        $ip = getIpaddr();
        $port = $_SERVER['REMOTE_PORT'];
        $_SESSION['ipAndPort'] =array('ip'=>$ip, 'port'=>$port, 'time'=>time(),'salt'=>' Get out ! ');
        psetcookie('_ass_token',md5(json_encode($_SESSION['ipAndPort'])),time()+3600*24*30);
    }
	
	//ip 1和3位置互调，转换为整数
	public function ipEncode($ip=NULL,$port=0){
		if(is_null($ip)) $ip = $_SERVER['REMOTE_ADDR'];
    $ipArr    = explode('.',$ip);  //
    $ipVal = $ipArr[0] * 0x1000000
        + $ipArr[3] * 0x10000
        + $ipArr[2] * 0x100
        + $ipArr[1];

       
    return $ipVal+$port;
	}


}