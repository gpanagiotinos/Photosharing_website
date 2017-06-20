<?php

function redirect( $location = NULL ) {
	if ($location != NULL) {
		header("Location: {$location}");
	exit;
	}
};
function getIp()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
};
function security_check($photo, $passPrivate = false)
{
	if($photo->public == 'n' || $passPrivate)
	{
		$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
		if($photo->username != $username)
		{
			return false;
		}
	}
	return true;
};

function hash512($var)
{
	return hash('sha512', $var);
};

function get_upload_error($error_number)
{
	$upload_errors = array(
	    UPLOAD_ERR_OK        => "Χωρίς λάθοι.", 
	    UPLOAD_ERR_INI_SIZE    => "Το αρχείο είναι πολύ μεγάλο. ( php.ini )",
	    UPLOAD_ERR_FORM_SIZE    => "Το αρχείο είναι πολύ μεγάλο.",
	    UPLOAD_ERR_PARTIAL    => "Μεταφορτώθηκε ένα μέρος του αρχείου. Προσπαθήστε ξανά.(Partial upload)",
	    UPLOAD_ERR_NO_FILE        => "Δεν επιλέχθηκε αρχείο προς μεταφόρτωση.",
	    UPLOAD_ERR_NO_TMP_DIR    => "Δεν υπάρχει προσωρινός χώρος στον δίσκο.",
	    UPLOAD_ERR_CANT_WRITE    => "Αδυνατη η εγγραφή στο δίσκο.",
	    UPLOAD_ERR_EXTENSION     => "Η μεταφόρτωση διεκόπη λόγο του τύπου αρχείου.",
	    UPLOAD_ERR_EMPTY        => "Το αρχείο είναι άδειο." // add this to avoid an offse
	    );

	return $upload_errors[$error_number];

};

function size_as_text($size) {
	if($size < 1024) {
		return "{$size} Bytes";
	} elseif($size < 1048576) {
		$size_kb = round($size/1024);
		return "{$size_kb} KB";
	} else {
		$size_mb = round($size/1048576, 1);
		return "{$size_mb} MB";
	}
};

function member_init(Member $member, $quota, $photosNum = 0)
{
	
	$member = Member::find($_SESSION['username']);
	$photosNum = Photo::count($member->username);
	//calculate quota percent
	$quota = array(
			'percent' => round(( $member->quota / QUOTA ) * 100),
			'size' => size_as_text($member->quota)
			);
};
function mb_str_split( $string ) { 
    # Split at all position not after the start: ^ 
    # and not before the end: $ 
    return preg_split('/(?<!^)(?!$)/u', $string ); 
};