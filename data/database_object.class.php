<?php

class Database_Object
{
	public static function prepare($sql = '')
	{
		global $database;
		if( !$stmt = $database->prepare($sql) )
		{
			die(print_r($database->errorInfo()));
		}

		return $stmt;
	}
	public static function last_id()
	{
		global $database;
		return $database->lastInsertId();
	}
}