<?php

class Search extends Database_Object
{
	//the sql type
	public $fullSearch;
	public $searchTerms;

	function __construct(){
		$this->searchTerms = array();
		$this->fullSearch = false;
	}

	private function create_query()
	{
		foreach ($this->searchTerms as $term) {
			$str = "(";
					if($this->fullSearch):
						$str .= "photos.title like '%{$term}%' or photos.caption like '%{$term}%' or ";
					endif;
			$str .= "photos.id in (
				SELECT `photo_id` FROM `tag_to_photo`
				INNER JOIN `tags` ON `tag_id` = `tags`.`id`
				WHERE name = '{$term}')
			)";
			$array[] = $str;
		}
		return implode(' AND ',$array);
	}

	public function search($limit, $offset)
	{
		$sql = "SELECT * FROM photos where ".$this->create_query()." AND photos.public = 'y' ORDER BY views DESC limit {$limit} offset {$offset}";
		
		$stmt = self::prepare($sql);
		$stmt->execute();

		$object_array = $stmt->fetchAll(PDO::FETCH_CLASS, 'Photo');
		return !empty($object_array) ? $object_array : false;
	}

	public function count()
	{
		$sql = "SELECT count(*) FROM photos where ".$this->create_query()." AND photos.public = 'y'";
		$stmt = self::prepare($sql);
		$stmt->execute();
		$num = array_shift($stmt->fetch(PDO::FETCH_ASSOC));
		return $num;	
	}
	
}