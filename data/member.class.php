<?php

class Member extends Database_Object
{
	private static $table_name = "members";

	public $username;
	public $password;
	public $email;
	public $quota;
	public $reg_date;


	public static function find($value, $key = 'username')
	{
		$stmt = parent::prepare("select * from `".self::$table_name."` where `{$key}` = :value limit 1");
		$stmt->bindParam(':value', $value);
		$stmt->execute();

		$object_array = $stmt->fetchAll(PDO::FETCH_CLASS, 'Member');
		return !empty($object_array) ? array_shift($object_array) : false;
	}
	public static function count($value, $key = 'username')
	{
		$stmt = parent::prepare("select count(*) from `".self::$table_name."` where `{$key}` = :value");
		$stmt->bindParam(':value', $value);
		$stmt->execute();
		$num = array_shift($stmt->fetch(PDO::FETCH_ASSOC));
		return $num;	
	}
	public function insert()
	{
		$stmt = parent::prepare("insert into `".self::$table_name."` (username,password,email,reg_date) values (:username,:password,:email,:reg_date)");
		$stmt->bindParam(':username', $this->username, PDO::PARAM_STR, 50);
		$stmt->bindParam(':password', $this->password, PDO::PARAM_STR, 512);
		$stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 50);
		$stmt->bindParam(':reg_date', $this->reg_date, PDO::PARAM_INT, 11);
		return ($stmt->execute()) ? true : false;
	}
	public function update()
	{
		$stmt = parent::prepare("update `".self::$table_name."` set `password` = :password , `email` = :email where `username` = :username limit 1");
		$stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 50);
		$stmt->bindParam(':password', $this->password, PDO::PARAM_STR, 512);
		$stmt->bindParam(':username', $this->username, PDO::PARAM_STR, 50);
		return ($stmt->execute()) ? true : false;
	}
	public function updateQuota($size, $sign = '+')
	{
		$stmt = parent::prepare("update `".self::$table_name."` set `quota` = `quota` ".$sign." :size where `username` = '".$this->username."' limit 1");
		$stmt->bindParam(':size', $size, PDO::PARAM_INT);
		return ($stmt->execute()) ? true : false;
	}
	public static function authenticate($username, $password)
	{
		$stmt = parent::prepare("select count(*) from `".self::$table_name."` where `username` = :username and `password` = :password limit 1");
		$stmt->bindParam(':username', $username, PDO::PARAM_STR, 50);
		$stmt->bindParam(':password', $password, PDO::PARAM_STR, 512);
		$stmt->execute();
		$num = array_shift($stmt->fetch(PDO::FETCH_ASSOC));
		return ($num == 1) ? true : false;
	}
	public function size_as_text() {
		if($this->size < 1024) {
			return "{$this->size} bytes";
		} elseif($this->size < 1048576) {
			$size_kb = round($this->size/1024);
			return "{$size_kb} KB";
		} else {
			$size_mb = round($this->size/1048576, 1);
			return "{$size_mb} MB";
		}
	}
}