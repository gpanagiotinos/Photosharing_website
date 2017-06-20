<?php

class Tag extends Database_Object
{
	
	private static $table_name = "tags";
	private static $assoc_table_name = "tag_to_photo";
	public $id;
	public $name;
	//auto complete
	public static function find_suggestions($str)
	{
		$stmt = self::prepare("select * from `".self::$table_name."` where `name` LIKE :str limit 8");
		$stmt->bindParam(':str', $str);
		$str.='%';
		$stmt->execute();

		$object_array = $stmt->fetchAll(PDO::FETCH_CLASS);
		return !empty($object_array) ? $object_array : false;
	}
	public static function find($value, $key = 'id')
	{
		$stmt = self::prepare("select * from `".self::$table_name."` where `{$key}` = :value limit 1");
		$stmt->bindParam(':value', $value);
		$stmt->execute();

		$object_array = $stmt->fetchAll(PDO::FETCH_CLASS, 'Tag');
		return !empty($object_array) ? array_shift($object_array) : false;
	}
	public static function count($value, $key = 'name')
	{
		$stmt = self::prepare("select count(*) from `".self::$table_name."` where `{$key}` = :value");
		$stmt->bindParam(':value', $value);
		$stmt->execute();
		$num = array_shift($stmt->fetch(PDO::FETCH_ASSOC));
		return $num;		
	}
	public static function is_duplicate($tag_id, $photo_id)
	{
		$stmt = self::prepare("select count(*) from `".self::$assoc_table_name."` where `tag_id` = :tag_id AND `photo_id` = :photo_id");
		$stmt->bindParam(':tag_id', $tag_id);
		$stmt->bindParam(':photo_id', $photo_id);
		$stmt->execute();
		$num = array_shift($stmt->fetch(PDO::FETCH_ASSOC));
		return $num;		
	}
	public function insert()
	{
		//check unique
		$this->name = strtolower($this->name);
		$tag = self::find($this->name,'name');
		if( !empty($tag) ){
			$this->id = $tag->id;
			return true;
		} 
		$sql = "insert into `".self::$table_name."` (`name`) values (:name)";
		$stmt = self::prepare($sql);
		$stmt->bindParam(':name', $this->name);
		if($stmt->execute()){
			$this->id = self::last_id();
			return true;
		}else{
			return false;
		}
	}
	public function delete()
	{
		$stmt = self::prepare("delete from `".self::$assoc_table_name."` where `tag_id` = ?");
		return ($stmt->execute(array($this->id))) ? true : false;
	}
	public function attach_to_photo($id)
	{
		//check for duplicate entry
		if(self::is_duplicate($this->id, $id) > 0){
			return false;
		}

		$sql = "insert into `".self::$assoc_table_name."` (`tag_id`,`photo_id`) values (:tag_id, :photo_id)";
		$stmt = self::prepare($sql);
		$stmt->bindParam(':tag_id', $this->id);
		$stmt->bindParam(':photo_id', $id);
		return ($stmt->execute()) ? true : false;
	}
	public static function photo_tags($id)
	{
		$sql = "select `".self::$table_name."`.`name`,`".self::$table_name."`.`id` from `".self::$assoc_table_name."` INNER JOIN `".self::$table_name."` ON `".self::$assoc_table_name."`.`tag_id` = `".self::$table_name."`.`id` where `".self::$assoc_table_name."`.`photo_id` = :id";
		$stmt = self::prepare($sql);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$tags_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return !empty($tags_array) ? $tags_array : false;
	}

}