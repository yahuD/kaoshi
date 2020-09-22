<?php
// Database connectivity setup
define('DB_PERSISTENCY', 'true');

// Class providing generic data access functionality
class DatabaseHandler
{
  // Hold an instance of the PDO class
  private static $_mHandler;

  // Private constructor to prevent direct creation of object
  private function __construct()
  {
  }

  // Return an initialized database handler 
  private static function GetHandler()
  {
    // Create a database connection only if one doesnt already exist
    if (!isset(self::$_mHandler))
    {
      // Execute code catching potential exceptions
      try
      {
        // Create a new PDO class instance
        self::$_mHandler =
          new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS,
                  array(PDO::ATTR_PERSISTENT => DB_PERSISTENCY, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.DB_CHARSET));

        // Configure PDO to throw exceptions
        self::$_mHandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }
      catch (PDOException $e)
      {
        // Close the database handler and trigger an error
        self::Close();
        trigger_error($e->getMessage(), E_USER_ERROR);
      }
    }

    // Return the database handler
    return self::$_mHandler;
  }

  // Clear the PDO class instance
  public static function Close()
  {
    self::$_mHandler = null;
  }

  // Wrapper method for PDOStatement::execute()
  public static function Execute($sqlQuery, $params = null)
  {
    // Try to execute an SQL query or a stored procedure
    try
    {
      // Get the database handler
      $database_handler = self::GetHandler();

      // Prepare the query for execution
      $statement_handler = $database_handler->prepare($sqlQuery);

      // Execute query
      $statement_handler->execute($params);
    }
    // Trigger an error if an exception was thrown when executing the SQL query
    catch(PDOException $e)
    {
      // Close the database handler and trigger an error
      self::Close();
      trigger_error($e->getMessage(), E_USER_ERROR);
    }
  }

  // Wrapper method for PDOStatement::fetchAll()
  public static function GetAll($sqlQuery, $params = null,
                                $fetchStyle = PDO::FETCH_ASSOC)
  {
    // Initialize the return value to null
    $result = null;

    // Try to execute an SQL query or a stored procedure
    try
    {
    		$database_handler = self::GetHandler();
	      $statement_handler = $database_handler->prepare($sqlQuery);

			if ( strpos($sqlQuery, 'LIMIT') === false )
			{
	      $statement_handler->execute($params);

			//修正PDO LIMIT 子句 bug
			}else if ( is_array($params) && !empty($params) ){
 
			  foreach( $params as $k => $v)
			  { 
		      $statement_handler->bindValue($k, $v, self::PDOdatatype($v));
		  	}
				$statement_handler->execute();
			}
	
	 
      // Fetch result
      $result = $statement_handler->fetchAll($fetchStyle);
    }
    // Trigger an error if an exception was thrown when executing the SQL query
    catch(PDOException $e)
    {
      // Close the database handler and trigger an error
      self::Close();
      trigger_error($e->getMessage(), E_USER_ERROR);  //var_dump($e->getMessage());
    }

    // Return the query results
    return $result;
  }

  // Wrapper method for PDOStatement::fetch()
  public static function GetRow($sqlQuery, $params = null,
                                $fetchStyle = PDO::FETCH_ASSOC)
  {
    // Initialize the return value to null
    $result = null;

    // Try to execute an SQL query or a stored procedure
    try
    {

      $database_handler = self::GetHandler();
      $statement_handler = $database_handler->prepare($sqlQuery);
      $statement_handler->execute($params);

      // Fetch result
      $result = $statement_handler->fetch($fetchStyle);
    }
    // Trigger an error if an exception was thrown when executing the SQL query
    catch(PDOException $e)
    {
      // Close the database handler and trigger an error
      self::Close();
      trigger_error($e->getMessage(), E_USER_ERROR);
    }

    // Return the query results
    return $result;
  }

  // Return the first column value from a row
  public static function GetOne($sqlQuery, $params = null)
  {
    // Initialize the return value to null    
    $result = null;

    // Try to execute an SQL query or a stored procedure
    try
    {
      // Get the database handler
      $database_handler = self::GetHandler();

      // Prepare the query for execution
      $statement_handler = $database_handler->prepare($sqlQuery);

      // Execute the query
      $statement_handler->execute($params);

      // Fetch result
      $result = $statement_handler->fetch(PDO::FETCH_NUM);

      /* Save the first value of the result set (first column of the first row)
         to $result */
      $result = $result[0];
    }
    // Trigger an error if an exception was thrown when executing the SQL query
    catch(PDOException $e)
    {
      // Close the database handler and trigger an error
      self::Close();
      trigger_error($e->getMessage(), E_USER_ERROR);
    }

    // Return the query results
    return $result;
  }

 public static function ExecuteInsert($sqlQuery, $params = null)

  {
		self::Execute($sqlQuery, $params);
		return self::$_mHandler->lastInsertId();
	}

  public static function ExecuteDelUpd($sqlQuery, $params = null)
  {
   try
    {
      // Get the database handler
      $database_handler = self::GetHandler();

      // Prepare the query for execution
      $statement_handler = $database_handler->prepare($sqlQuery);

      // Execute query
      $statement_handler->execute($params);
    }
    // Trigger an error if an exception was thrown when executing the SQL query
    catch(PDOException $e)
    {
      // Close the database handler and trigger an error
      self::Close();
      trigger_error($e->getMessage(), E_USER_ERROR);
    }

  	return $statement_handler->rowCount();
  }

/*
  public static function ExecuteInsert($sqlQuery, $params = null)
  {
   try
    {
      // Get the database handler
      $database_handler = self::GetHandler();

      // Prepare the query for execution
      $statement_handler = $database_handler->prepare($sqlQuery);

      // Execute query
      $statement_handler->execute($params);
    }
    // Trigger an error if an exception was thrown when executing the SQL query
    catch(PDOException $e)
    {
      // Close the database handler and trigger an error
      self::Close();
      trigger_error($e->getMessage(), E_USER_ERROR);
    }

  	return $database_handler->lastInsertId();
  }
*/


private function PDOdatatype( $val )
	{
    if (is_bool($val)) {
        return PDO::PARAM_BOOL;
    } elseif (is_int($val)) {
        return PDO::PARAM_INT;
    } elseif (is_null($val)) {
        return PDO::PARAM_NULL;
    } else {
        return PDO::PARAM_STR;
    }
	}
}
?>
