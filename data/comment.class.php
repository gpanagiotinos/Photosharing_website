<?php

class Comment extends Database_Object
{

	private static $table_name = "comments";
	public $id;
	public $pid;
	public $username;
	public $date;
	public $comment;

	public static function find($value, $key = 'id')
	{
		$stmt = self::prepare("select * from `".self::$table_name."` where `{$key}` = :value limit 1");
		$stmt->bindParam(':value', $value);
		$stmt->execute();

		$object_array = $stmt->fetchAll(PDO::FETCH_CLASS, 'Comment');
		return !empty($object_array) ? array_shift($object_array) : false;
	}
	public static function findAll($pid)
	{
		$stmt = self::prepare("select * from `".self::$table_name."` where `pid` = :pid order by `id` ASC");
		$stmt->bindParam(':pid', $pid);
		$stmt->execute();
		$array = $stmt->fetchAll(PDO::FETCH_CLASS, 'Comment');
		return !empty($array) ? $array : false;
	}
	public static function count($value, $key = 'pid')
	{
		$stmt = self::prepare("select count(*) from `".self::$table_name."` where `{$key}` = :value");
		$stmt->bindParam(':value', $value);
		$stmt->execute();
		$num = array_shift($stmt->fetch(PDO::FETCH_ASSOC));
		return $num;		
	}
	public function insert()
	{
		$sql = "insert into `".self::$table_name."` (`pid`, `username`, `date`, `comment`) values (:pid, :username, :date, :comment)";
		$stmt = self::prepare($sql);
		$stmt->bindParam(':pid', $this->pid);
		$stmt->bindParam(':username', $this->username);
		$stmt->bindParam(':date', $this->date);
		$stmt->bindParam(':comment', $this->comment);
		if($stmt->execute()){
			$this->id = self::last_id();
			return true;
		}else{
			return false;
		}
	}
	public function delete()
	{
		$stmt = self::prepare("delete from `".self::$table_name."` where `id` = ?");
		return ($stmt->execute(array($this->id))) ? true : false;
	}

}