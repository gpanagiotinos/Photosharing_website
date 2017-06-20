<?php

class Photo extends Database_Object
{
	private static $table_name = 'photos';
	
	public $id;
	public $username;
	public $title;
	public $caption;
	public $public;
	public $upload_date;
	public $path;
	public $thumb_path;
	public $views;
	public $size;
	public $lat;
	public $lng;
	public $address;

	//rest required properties
	private static $image_folder = 'uploads/';
	private $temp_path;
	private $filename;
	public $type;
	public $errors = array(); // Variable to hold all the errors 

	public static function find($value, $key = 'id', $limit = 1)
	{
		$stmt = self::prepare("select * from `".self::$table_name."` where `{$key}` = :value limit {$limit}");
		$stmt->bindParam(':value', $value);
		$stmt->execute();

		$object_array = $stmt->fetchAll(PDO::FETCH_CLASS, 'Photo');
		return !empty($object_array) ? array_shift($object_array) : false;
	}
	public static function select($username, $limit, $offset)
	{
		$stmt = self::prepare("select * from `".self::$table_name."` where `username` = :username order by `id` DESC limit {$limit} offset {$offset}");
		$stmt->bindParam(':username', $username);
		$stmt->execute();

		$object_array = $stmt->fetchAll(PDO::FETCH_CLASS, 'Photo');
		return !empty($object_array) ? $object_array : false;
	}
	public static function popular($limit)
	{
		$stmt = self::prepare("select * from `".self::$table_name."` where `public` = 'y' order by `views` DESC limit {$limit}");
		$stmt->execute();

		$object_array = $stmt->fetchAll(PDO::FETCH_CLASS, 'Photo');
		return !empty($object_array) ? $object_array : false;
	}
	public static function map($lat,$lng)
	{
		$offset = 0.8;
		$sql = "select * from `".self::$table_name."` where `lat` between '".((float)$lat - (float)$offset)."' and '".((float)$lat + (float)$offset)."' and `lng` between '".((float)$lng - (float)$offset)."' and '".((float)$lng + (float)$offset)."' ";
		$stmt = self::prepare($sql);
		$stmt->execute();

		$object_array = $stmt->fetchAll(PDO::FETCH_CLASS, 'Photo');
		return !empty($object_array) ? $object_array : false;
	}
	public static function count($value, $key = 'username')
	{
		$stmt = self::prepare("select count(*) from `".self::$table_name."` where `{$key}` = :value");
		$stmt->bindParam(':value', $value);
		$stmt->execute();
		$num = array_shift($stmt->fetch(PDO::FETCH_ASSOC));
		return $num;		
	}
	//multi uplaod 
	public static function deleteDir($dirPath) {
		//check if is dir
	    if (! is_dir($dirPath)) {
	        throw new InvalidArgumentException('$dirPath must be a directory');
	    }
	    //attach the / sign if not exists
	    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
	        $dirPath .= '/';
	    }
	    //get all type of files
	    $files = glob($dirPath . '*', GLOB_MARK);
	    //delete files or call itself in case of dir
	    foreach ($files as $file) {
	        if (is_dir($file)) {
	            self::deleteDir($file);
	        } else {
	            unlink($file);
	        }
	    }
	    //Lastly remove dir given
	    rmdir($dirPath);
    }
    
	public static function unzip_and_instantiate($zip)//paths is an array of zip and xml path
	{
		if(!$zip || empty($zip) || !is_array($zip) || $zip['error'] || $zip['type'] != 'application/zip')
		{
			return false;
		}
		//init usefull paths
		$list = array();
		$temp_path = dirname($zip['tmp_name']);
		$temp_archive_path = $temp_path.'/archive'.uniqid();
		$list['path'] = $temp_archive_path;
		

		
		//extract zip
		$z = new ZipArchive();
		if($z->open($zip['tmp_name'])){
			$z->extractTo($temp_archive_path);
			$z->close();
		}
		unset($z);
		$isXML = file_exists($temp_archive_path.'/info.xml');
		if($isXML)
		{
			//xml to array
			$xmlstring = file_get_contents($temp_archive_path.'/info.xml');
			$xmlObj = simplexml_load_string($xmlstring);
			$json = json_encode($xmlObj);
			$xmlArray = json_decode($json,TRUE);
		}	
		//opendir
		$dir = opendir($temp_archive_path);
		while($file = readdir($dir)){
			//instantiate
			$file = basename($file); //this name must be the same as xml name
			$imageInfo = getimagesize($temp_archive_path.'/'.$file);		
			$type = $imageInfo['mime'];
			if($type == "image/jpeg" || $type == "image/png"){
				//create new instance
				$photo = new self();
				//attach_file_manual
				$photo->temp_path = $temp_archive_path.'/'.$file;
				$photo->filename = $file;
				$photo->size = filesize($temp_archive_path.'/'.$file);
				$photo->type = $type;
				if($isXML)
				{
					//attach xml info if exists
					//...
					foreach($xmlArray as $photoInfo)
					{
						
						if(!strcmp($photoInfo['name'],$file))//is name equal
						{	
							
							empty($photoInfo['title']) ? null : $photo->title = $photoInfo['title'];
							empty($photoInfo['caption']) ? null : $photo->caption = $photoInfo['caption'];
							empty($photoInfo['public']) ? null : $photo->public = $photoInfo['public'];
							empty($photoInfo['lat']) ? null : $photo->lat = $photoInfo['lat'];
							empty($photoInfo['lng']) ? null : $photo->lng = $photoInfo['lng'];
							empty($photoInfo['address']) ? null : $photo->address = $photoInfo['address'];
						}
					}
				}
				$list['photos'][] = $photo; // Photo object array
				unset($photo);
			}
			unset($imageInfo);unset($type);
		}
		
		return $list;
	}
	public function attach_file($file)
	{
		if(!$file || empty($file) || !is_array($file))
		{
			$this->errors[] = 'Δεν υπάρχει αρχείο';
			return false;
		}elseif ($file['error']) {
			$this->errors[] = get_upload_error($file['error']);
			return false;
		}else{
			$this->temp_path = $file['tmp_name'];
			//die($file['tmp_name']);
			$this->filename = $file['name'];
			$this->type = $file['type'];
			$this->size = $file['size'];

			return true;
		}
	}

	public function upload_and_save($currentQuota)
	{
		if(!empty($this->errors))
		{
			return false;
		}

		if(empty($this->filename) || empty($this->temp_path))
		{
			$this->errors[] = 'Δεν βρέθηκε η τοποθεσία για μεταφόρτωση';
			return false;
		}

		//Check type
		if($this->type != 'image/jpeg' && $this->type != 'image/png')
		{
			$this->errors[] = 'Υποστηρίζονται μόνο φωτογραφίες τύπου jpeg / png. | '.$this->type;
			return false;
		}
		//Create random filename
		$ext = array_pop( explode('.', $this->filename) );
		$this->filename = uniqid().'.'.$ext;
		//init the path
		$this->path = self::$image_folder.$this->filename;
		if(file_exists($this->path))
		{
			$this->errors[] = "Το αρχείο {$this->filename} υπάρχει.";
			return false; 
		}
		//CHECK IF RESIZE IS REQUIRED
		//currently image is at temp path
		$image = new Image();
		//load the temp image
		$image->load($this->temp_path);
		//check image width
		if( $image->getWidth() > MAX_WIDTH)
		{
			$image->resizeToWidth(MAX_WIDTH);
			if(!$image->save($this->temp_path, $this->type, 100))
			{
				$this->errors[] = "Σφάλμα κατα το resize";
				return false;
			}
			//set the new size
			//$this->size = $image->getSize($this->temp_path);
			
		}
		if ($image->getHeight() > MAX_HEIGHT ) {
			$image->resizeToHeight( MAX_HEIGHT );
			if (!$image->save($this->temp_path, $this->type, 100)) {
				
				$this->errors[] = "Σφάλμα κατα το resize";
				return false;
			}
			//$this->size = $image->getSize($this->temp_path);
			
		}
		$image->destroy();
		//update size
		$this->size = filesize($this->temp_path);
		//Check size

		if($this->size > 5242880)
		{
			$this->errors[] = 'Το αρχείο είναι πολύ μεγάλο. ( Έως 5mb ).';
			return false;
		}
		if( $currentQuota + $this->size > QUOTA )
		{
			$this->errors[] = 'Δεν υπάρχει διαθέσιμος χώρος για την μεταφόρτωση της φωτογραφίας.';
			return false;
		}
		//Upload the file
		if(is_uploaded_file($this->temp_path)) //check if file came from the HTTP POST FORM
		{
			if(move_uploaded_file($this->temp_path, $this->path))
			{
				if($this->insert())
				{
					unset($this->temp_path);
					$this->id = self::last_id();
					return true;
				}
			}else{
				$this->errors[] = 'Η μεταφόρτωση απέτυχε :(';
				return false;
			}
		}else{
			if(copy($this->temp_path, $this->path))
			{
				if($this->insert())
				{
					unset($this->temp_path);
					$this->id = self::last_id();
					return true;
				}
			
			}else{
				$this->errors[] = 'Η μεταφόρτωση απέτυχε :( ( multi-copy )';
				return false;
			}
		}
		
	}
	//resize image

	public function insert()
	{
		$sql = "insert into `".self::$table_name."` (`username`,`upload_date`,`path`,`type`, `size`) values (:username, :upload_date, :path, :type, :size)";
		$stmt = self::prepare($sql);
		$stmt->bindParam(':username', $this->username);
		$stmt->bindParam(':upload_date', $this->upload_date);
		$stmt->bindParam(':path', $this->path);
		$stmt->bindParam(':type', $this->type);
		$stmt->bindParam(':size', $this->size);

		return ($stmt->execute()) ? true : false;	
	}

	public function update()
	{
		
		$sql = "update `".self::$table_name."` set `title` = :title, `caption` = :caption, `public` = :public, `lat` = :lat,`lng` = :lng, `address` = :address, `thumb_path` = :thumb_path where `id` = :id";
		$stmt = self::prepare($sql);
		$stmt->bindParam(':title', $this->title);
		$stmt->bindParam(':caption', $this->caption);
		$stmt->bindParam(':public', $this->public);
		$stmt->bindParam(':thumb_path', $this->thumb_path);
		$stmt->bindParam(':id', $this->id);
		$stmt->bindParam(':lat', $this->lat);
		$stmt->bindParam(':lng', $this->lng);
		$stmt->bindParam(':address', $this->address);
		return ($stmt->execute()) ? true : false;
	}

	public function delete()
	{
		$stmt = self::prepare("delete from `".self::$table_name."` where `id` = ?");
		return ($stmt->execute(array($this->id))) ? true : false;
	}

	public function destroy()
	{
		if($this->delete())
		{
			return unlink($this->path) ? true : false;
		}else{
			return false;
		}
	}
	
}