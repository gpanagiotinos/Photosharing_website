<?php

require_once('lib/initialize.php');

$session->require_logged_in();

//member vars init
$member = new Member();
$tpl = new Template();

member_init(&$member, &$quota, &$photosNum);
$tpl->assign('member',$member);
$tpl->assign('photosNum',$photosNum);

$tpl->assign('quota',$quota);

$action = isset($_GET['action']) ? $_GET['action'] : false;

switch ($action) {
	case 'edit':

		$photo_id = isset($_GET['pid']) ? (int)$_GET['pid'] : false;
		if(!$photo_id)
		{
			$session->message("Τα στοιχεια δεν ήταν πλήρη.");
			$session->messageType("alert");
			redirect(SITE_PATH.'index.php');
			exit;
		}
		//get photo object
		if(!$photo = Photo::find($photo_id,'id'))
		{
			die("Cant retrieve photo information");
		}
		//check auth
		if($photo->username != $member->username)
		{
			$session->message('Nothing to do here.');
			$session->messageType("error");
			redirect(SITE_PATH.'index.php');
			exit;
		}
		//get tags
		$tags = Tag::photo_tags($photo->id);
		if(empty($tags)) $tags = array();
		$tpl->assign('tags', $tags);
		if(isset($_POST['editImage']))
		{
			$errors = false;
			if(empty($_POST['title']) || empty($_POST['caption']))
			{
				$errors = true;
				$session->message('Μερικά πεδία είναι κενά.',false);
				$session->messageType("alert",false);
			}
			if(!$errors)
			{
				$photo->title = $_POST['title'];
				$photo->caption = $_POST['caption'];
				$photo->public = $_POST['public']?'y':'n';

				$photo->lat = $_POST['lat'];
				$photo->lng = $_POST['lng'];
				$photo->address = $_POST['address'];
				//create a thumbnail
				$isThumb = file_exists($photo->thumb_path);
				if($_POST['public'])
				{
					if(!$isThumb)
					{
						//create the thumbnail
						$image = new Image();
						$image->load($photo->path);
						$image->crop(150, .5, $photo->type);
						//Create random filename
						$ext = array_pop( explode('.', $photo->path) );
						$photo->thumb_path = THUMBS_PATH.uniqid().'.'.$ext;
						$image->saveThumb($photo->thumb_path, $photo->type);
						$image->destroy();
					}

				}else{
					//delete thumbnail
					if($isThumb)
					{
						@unlink($photo->thumb_path);
					}

				}
				//free
				unset($isThumb);
				//end of thumb code
				if($photo->update())
				{
					if(!empty($_POST['tags'])){
					//manipulate tags
					$tags = explode(' ', $_POST['tags']);
						foreach ($tags as $t) {
							if(empty($t)) continue;
							$tag = new Tag();
							$tag->name = $t;
							//save to associate table
							$tag->insert();
							//save tag in tag table and protect the unique property
							$tag->attach_to_photo($photo->id);
						}
					}

					$session->message('Η αποθήκευση έγινε με επιτυχία.');
					$session->messageType("success");
					redirect(SITE_PATH.'photos.php');
					exit;
				}else{
					$session->message('Κάτι πήγε στραβά. Δοκιμάστε ξανά.',false);
					$session->messageType("error",false);
				}
			}
		}
		//assign the photo object to edit form
		$tpl->assign('photo',$photo);
		$tpl->render('edit_photo','Επεξεργασία');
		
		break;
	case 'upload':
	
		if(isset($_POST['upload_image'])){ 
			$photo = new Photo();
			$photo->upload_date = time();
			$photo->username = $member->username;
			$photo->attach_file($_FILES['memberImage']);
			if($photo->upload_and_save($member->quota))
			{
				//update quota
				if(!$member->updateQuota($photo->size))
				{
					$session->message("Η φωτογραφία μεταφορτώθηκε αλλα το quota δεν ανανεώθηκε :(");
					$session->messageType("error");
				}else{

					$session->message("Η μεταφόρτωση έγινε με επιτυχία.");
					$session->messageType("success");
				}

				redirect(SITE_PATH.'photos.php?action=edit&pid='.$photo->id);
			}else{
				$session->message(join("<br />", $photo->errors), false);
				$session->messageType("alert", false);
			}
		}


		$tpl->render('upload', 'Μεταφόρτωση');

		break;
	case 'multi_upload':
		if(isset($_POST['multi_upload_images']))
		{
			$list = Photo::unzip_and_instantiate($_FILES['zipFile']);
			//die(print_r($list));
			if(empty($list['photos']) || !$list['path']){
				$session->message("Προβλημα στο zip αρχείο.Δοκιμάστε ξανα.");
				$session->messageType("error");
				redirect(SITE_PATH.'photos.php');
				exit;
			}
			$errors = false;
			foreach($list['photos'] as $photo)
			{
				$photo->upload_date = time();
				$photo->username = $member->username;
				
				if($photo->upload_and_save($member->quota))
				{
					$member->updateQuota($photo->size);
					$member->quota += $photo->size;	
					//update from xml info
					if(isset($photo->title))
					{
						$photo->update();
					}			
				}else{
					$errors = true;
					$messages[] = join("<br />", $photo->errors);			
				}
				
			}//foreach
			if($errors)
			{
				$session->message(join("<br />", $messages));
				$session->messageType("error");
			}else{
				$session->message('Η μεταφόρτωση έγινε με επιτυχία.');
				$session->messageType("success");
			}
			//delete temp path
			Photo::deleteDir($list['path']);
			redirect(SITE_PATH.'photos.php');
			exit;
		}
		
		$tpl->render('upload', 'Μεταφόρτωση');
		break;
	case 'delete':
		$photo_id = isset($_GET['pid'])?(int)$_GET['pid']:false;
		if(!$photo_id)
		{
			//No photo selected to edit.
			redirect(SITE_PATH.'index.php');
			exit;
		}
		//get photo object
		if(!$photo = Photo::find($photo_id,'id'))
		{
			die("Cant retrieve photo information");
		}
		//check auth
		if($photo->username != $member->username)
		{
			$session->message('Nothing to do here.');
			$session->messageType("error");
			redirect(SITE_PATH.'index.php');
			exit;
		}
		if($photo->destroy() && $member->updateQuota($photo->size,'-'))
		{
			//delete tags
			
			$session->message('Το αρχείο διεγράφη.');
			$session->messageType("success");
			redirect(SITE_PATH.'photos.php');
			exit;
		}else{
			$session->message('Κάτι πηγε στραβά. Το αρχείο δεν διεγράφη.');
			$session->messageType("alert");
			redirect(SITE_PATH.'photos.php');
			exit;
		}

		break;
	default:
		//init pagination
		//check for page num
		$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
		$per_page = PER_PAGE;
		$total_count = Photo::count($member->username);
		//create the pagination object
		$pagination = new Pagination($page, $per_page, $total_count);
		//query with limit and offset
		$photos = Photo::select($member->username, $per_page, $pagination->offset());
		//Send logged data to template
		if(empty($photos)) $photos = array();
		//create the navigate anchers
		if($pagination->has_previous_page())
		{
			$tpl->assign('prevPageQuery', 'page='.$pagination->previous_page());
		}
		if($pagination->has_next_page())
		{	
			$queryData['page'] = $pagination->next_page();

			$tpl->assign('nextPageQuery', 'page='.$pagination->next_page());
		}

		$list = ( $pagination->total_pages() > 1 ) ? $pagination->create_page_list('photos.php') : array();
		
		if(!empty($list)){
			$tpl->assign('list', $list);
		}
		//render the page
		$tpl->assign('photos',$photos);

		$tpl->render('photos', 'Φωτογραφίες');
		break;
}//switch

