<?php


class Log extends Database_Object
{
	protected $table_name = "log_visitors";
	protected $photos_table_name = "photos";
	private $ip;
	private $pid;
	private $timeout;//Theoroume san new visitor ka8e IP pou anenewnetai gia ta epomena 30 lepta

	function __construct($pid)
	{
		$this->ip = ip2long(getIp());
		$this->pid = $pid;
		$this->timeout = TIMEOUT;
	}
	public function go()
	{
		if($this->find() > 0)
		{
			$this->update();
		}else{
			$this->insert();
			$this->updateViews();
		}

		$this->cleanUp();
	}

	private function find()
	{
		$sql = "SELECT count(*) FROM `" . $this->table_name . "` WHERE `pid` = :pid 
           AND `ip` = :ip AND `timestamp` > ".(time() - $this->timeout);
        $stmt = self::prepare($sql);
        $stmt->bindParam(':pid', $this->pid);
        $stmt->bindParam(':ip', $this->ip);
		$stmt->execute();
		$num = array_shift($stmt->fetch(PDO::FETCH_ASSOC));
		return $num;       
	}

	private function insert()
	{
		$sql = "INSERT INTO `" . $this->table_name . "` (`ip`,`timestamp`,`pid`) values (:ip, ".time().", :pid)";
		$stmt = self::prepare($sql);
		$stmt->bindParam(':pid', $this->pid);
	    $stmt->bindParam(':ip', $this->ip);

	    return ($stmt->execute()) ? true : false;
	}
	private function update()
	{
		$sql = "UPDATE `" . $this->table_name . "` SET `timestamp` = ".time()." WHERE `pid` = :pid and `ip` = :ip LIMIT 1";
		$stmt = self::prepare($sql);
		$stmt->bindParam(':pid', $this->pid);
	    $stmt->bindParam(':ip', $this->ip);

	    return ($stmt->execute()) ? true : false;
	}
	private function updateViews()
	{
		$sql = "UPDATE `" . $this->photos_table_name . "` SET `views` = `views` + 1 WHERE id = :pid";
		$stmt = self::prepare($sql);
		$stmt->bindParam(':pid', $this->pid);

		return ($stmt->execute()) ? true : false;
	}
	private function cleanUp()
	{
		if (rand(1,8) < 2) {
    		$sql = "DELETE from `" . $this->table_name . "` WHERE `timestamp` < ".(time() - $this->timeout);
			$stmt = self::prepare($sql);
			$stmt->execute();
		}
	}
}