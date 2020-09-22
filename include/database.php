<?php

/**
 * Displays : 数据库操作类 需要PDO扩展支持
 * Author   : phpox
 * Date     : Sun Nov 08 17:53:52 CST 2009
 */


defined('PHPOX') or die(header("HTTP/1.1 403 Not Forbidden"));

class include_database
{
    private static $instance;
	public $dsn;
	public $dbuser;
	public $dbpass;
	public $sth;
	public $dbh;
	public $conn;

	function __construct()
	{
		if(!SYSTEM_RUN){
			echo '<br><br><br><br><br><br><center><img src="/images/maintenance.png" /><p style="font-size:36px; color:#F60;">网站维护中......</p></center>
';
			die;
		}
		$this->dsn = 'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME;
		$this->dbuser = DB_USER;
		$this->dbpass = DB_PASS;
		$options = array( PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . DB_CHARSET ,PDO::ATTR_PERSISTENT => true);
		$this->connect( $options );
	}

	static function getInstance()
	{
	    if (self::$instance === null)
	    {
	        self::$instance = new include_database();
	    }
	    return self::$instance;
	}

	//连接数据库
	function connect( $options = '' )
	{
		try
		{
			$this->dbh = new PDO($this->dsn,$this->dbuser,$this->dbpass, $options );
		}
		catch (PDOException $e)
		{
			exit('数据库连接失败:'.$e->getMessage());
		}
	}

	//按SQL语句查询 model为true时返回单行记录
	function doSql($sql,$model=false,$debug = false)
	{
	    if ($debug)echo $sql;
	    $this->sth = $this->dbh->query($sql);
	    $this->getPDOError();
		$this->sth->setFetchMode(PDO::FETCH_ASSOC);
		$this->getPDOError();
		if ($model == false)
		{
			$result = $this->sth->fetchAll();
			$this->getPDOError();
		}else
		{
			$result = $this->sth->fetch();
			$this->getPDOError();
		}
		$this->sth = null;
		return $result;
	}

	/**
	 * 执行无返回值的SQL查询
	 *
	 */
	function execute($sql)
	{
		$res = $this->dbh->exec($sql);
		$this->getPDOError();
		return $res;
	}

	/**
	 * 查询记录数
	 */
	function counts($table,$condition=null)
	{
		$sql = "SELECT COUNT(*) AS num FROM `$table`";
		if($condition)
		{
			$sql .= " WHERE ".$condition;
		}
		$row = $this->doSql($sql,true);
		return $row['num'];
	}

	/**
	 * 递增
	 */
	function increment($table,$filed,$condition)
	{
		$sql = "UPDATE `$table` SET $filed=$filed+1 WHERE ".$condition;
		$res = $this->execute($sql);
		$this->getPDOError();
		return $res;
	}

	/**
	 * 返回最后插入的id
	 */
	function getLastInsertId()
	{
		$lastid = $this->dbh->lastInsertId();
		$this->getPDOError();
		return $lastid;
	}

	/**
	 * 捕获PDO错误信息
	 */
	function getPDOError()
	{
		if ($this->dbh->errorCode() != '00000')
		{
			$error = $this->dbh->errorInfo();
			exit($error[2]);
		}
	}

	//关闭数据连接
	function __destruct()
	{
		session_write_close();//在DB对象被析构之前触发SESSION写入事件
		//$this->dbh = null;   //edited by zht 161009
	}
}