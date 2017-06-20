<?php

class DB extends PDO{

	public static function exception_hanler($exception)
	{
		//Output the exception
		die('Uncaught exception: '.$exception->getMessage());
	}

	function __construct()
	{
		//Temp Change exception handler
		set_exception_handler(array(__CLASS__, 'exception_hanler'));
		//get the ini file
		if( !$config = parse_ini_file('db.ini', true) ) throw new exception('Unable to open ini file');
		//create the PDO object
		parent::__construct('mysql:host=localhost;port='.$config['database']['port'].';dbname='.$config['database']['dbname'], $config['database']['username'], $config['database']['password'], array());

		//Restore the handler
		restore_exception_handler();
	}

	public function init()
	{
		$this->exec("set character set utf8");
		$this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	}

}

//Create the db instance
$database = new DB();
$database->init();