<?php


class UploadImage
{

    var $directory_name;
    var $max_filesize;
    var $error;
    var $user_tmp_name;
    var $user_file_name;
    var $user_file_size;
    var $user_file_type;
    var $user_full_name;
    var $thumb_name;
    var $thumbnailImageName;
    public static $FILE_SIZE_ERROR = 1;
    public static $FILE_EMPTY_ERROR = 2;
    public static $FILE_UPLOAD_ERROR = 3;
    public static $FILE_COPY_ERROR = 4;

    function set_directory($dir_name = ".")
    {
	$this->directory_name = $dir_name;
    }

    function set_max_size($max_file = 300000)
    {
	$this->max_filesize = $max_file;
    }

    function error()
    {
	return $this->error;
    }

    function is_ok()
    {
	if(isset($this->error))
	{
	    return FALSE;
	}
	else
	{
	    return TRUE;
	}
    }

    public function setFileDetails($file, $prefix)
    {
	$tempName = $prefix."_".time();
	$imageName = $tempName."_".$file['name'];
	$this->imageThumbnail = "thumb_".$tempName;

	$this->set_tmp_name($file['tmp_name']);
	$this->set_file_size($file['size']);
	$this->set_file_type($file['type']);
	$this->set_file_name($imageName);
	$this->set_thumbnail_name($this->imageThumbnail);
    }

    function set_tmp_name($temp_name)
    {
	$this->user_tmp_name = $temp_name;
    }

    function set_file_size($file_size)
    {
	$this->user_file_size = $file_size;
    }

    function set_file_type($file_type)
    {
	$this->user_file_type = $file_type;
    }

    function set_file_name($file)
    {
	$this->user_file_name = $file;
	$this->user_full_name = $this->directory_name."/".$this->user_file_name;
    }

    function resize($max_width = 0, $max_height = 0)
    {
	if(eregi("\.png$", $this->user_full_name))
	{
	    $img = imagecreatefrompng($this->user_full_name);
	}

	if(eregi("\.(jpg|jpeg)$", $this->user_full_name))
	{
	    $img = imagecreatefromjpeg($this->user_full_name);
	}

	if(eregi("\.gif$", $this->user_full_name))
	{
	    $img = imagecreatefromgif($this->user_full_name);
	}

	$FullImage_width = imagesx($img);
	$FullImage_height = imagesy($img);

	if(isset($max_width) && isset($max_height) && $max_width != 0 && $max_height != 0)
	{
	    $new_width = $max_width;
	    $new_height = $max_height;
	}
	else if(isset($max_width) && $max_width != 0)
	{
	    $new_width = $max_width;
	    $new_height = ((int) ($new_width * $FullImage_height) / $FullImage_width);
	}
	else if(isset($max_height) && $max_height != 0)
	{
	    $new_height = $max_height;
	    $new_width = ((int) ($new_height * $FullImage_width) / $FullImage_height);
	}
	else
	{
	    $new_height = $FullImage_height;
	    $new_width = $FullImage_width;
	}

	$full_id = imagecreatetruecolor($new_width, $new_height);
// Check transparent gif and pngs
	if(eregi("\.png$", $this->user_full_name) || eregi("\.gif$", $this->user_full_name))
	{
	    $trnprt_indx = imagecolortransparent($img);
	    $trnprt_color = imagecolorsforindex($img, $trnprt_indx);
	    $trnprt_indx = imagecolorallocate($full_id, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
	    imagefill($full_id, 0, 0, $trnprt_indx);
	    imagecolortransparent($full_id, $trnprt_indx);
	}

	imagecopyresampled($full_id, $img, 0, 0, 0, 0, $new_width, $new_height, $FullImage_width, $FullImage_height);


	if(eregi("\.(jpg|jpeg)$", $this->user_full_name))
	{
	    $full = imagejpeg($full_id, $this->user_full_name, 100);
	}

	if(eregi("\.png$", $this->user_full_name))
	{
	    $full = imagepng($full_id, $this->user_full_name);
	}

	if(eregi("\.gif$", $this->user_full_name))
	{
	    $full = imagegif($full_id, $this->user_full_name);
	}

	imagedestroy($full_id);
	unset($max_width);
	unset($max_height);
    }

    function start_copy()
    {
	if(!isset($this->user_file_name))
	{
//	    $this->error = "You must define filename!";
	    $this->error = UploadImage::$FILE_EMPTY_ERROR;
	}

	if($this->user_file_size <= 0)
	{
	    $this->error = UploadImage::$FILE_SIZE_ERROR;
	}

	if($this->user_file_size > $this->max_filesize)
	{
	    $this->error = UploadImage::$FILE_SIZE_ERROR;
	}

	if(!isset($this->error))
	{
	    $filename = basename($this->user_file_name);

	    if(!empty($this->directory_name))
	    {
		$destination = $this->user_full_name;
	    }
	    else
	    {
		$destination = $filename;
	    }

	    if(!is_uploaded_file($this->user_tmp_name))
	    {
//		$this->error = "File ".$this->user_tmp_name." is not uploaded correctly.";
		$this->error = UploadImage::$FILE_UPLOAD_ERROR;
	    }

	    if(!@move_uploaded_file($this->user_tmp_name, $destination))
	    {
//		$this->error = "Impossible to copy ".$this->user_file_name." from source to destination directory.";
		$this->error = UploadImage::$FILE_COPY_ERROR;
	    }
	}
    }

    function set_thumbnail_name($thumbname)
    {
	if(preg_match("/\.png$/", $this->user_full_name))
	{
	    $this->thumb_name = $this->directory_name."/".$thumbname.".png";
	}

	if(preg_match("/\.(jpg|jpeg)$/", $this->user_full_name))
	{
	    $this->thumb_name = $this->directory_name."/".$thumbname.".jpg";
	}

	if(preg_match("/\.gif$/", $this->user_full_name))
	{
	    $this->thumb_name = $this->directory_name."/".$thumbname.".gif";
	}
    }

    function create_thumbnail()
    {
	if(!copy($this->user_full_name, $this->thumb_name))
	{
	    echo "<br>".$this->user_full_name.", ".$this->thumb_name."<br>";
	    echo "failed to copy $file...<br />\n";
	}
    }

    function set_thumbnail_size($max_width = 0, $max_height = 0)
    {
	if(preg_match("/\.png$/", $this->thumb_name))
	{
	    $img = ImageCreateFromPNG($this->thumb_name);
	}

	if(preg_match("/\.(jpg|jpeg)$/", $this->thumb_name))
	{
	    $img = ImageCreateFromJPEG($this->thumb_name);
	}

	if(preg_match("/\.gif$/", $this->thumb_name))
	{
	    $img = ImageCreateFromGif($this->thumb_name);
	}

	$FullImage_width = imagesx($img);
	$FullImage_height = imagesy($img);

	if(isset($max_width) && isset($max_height) && $max_width != 0 && $max_height != 0)
	{
	    $new_width = $max_width;
	    $new_height = $max_height;
	}
	else if(isset($max_width) && $max_width != 0)
	{
	    $new_width = $max_width;
	    $new_height = ((int) ($new_width * $FullImage_height) / $FullImage_width);
	}
	else if(isset($max_height) && $max_height != 0)
	{
	    $new_height = $max_height;
	    $new_width = ((int) ($new_height * $FullImage_width) / $FullImage_height);
	}
	else
	{
	    $new_height = $FullImage_height;
	    $new_width = $FullImage_width;
	}

	$full_id = ImageCreateTrueColor($new_width, $new_height);

// Check transparent gif and pngs
	if(preg_match("/\.png$/", $this->user_full_name) || preg_match("/\.gif$/", $this->user_full_name))
	{
	    $trnprt_indx = imagecolortransparent($img);

	    if($trnprt_indx != -1)
	    {
		$trnprt_color = imagecolorsforindex($img, $trnprt_indx);
	    }
	    else
	    {
		$trnprt_color = array("red" => "0", "green" => "0", "blue" => "0");
	    }

	    $trnprt_indx = imagecolorallocate($full_id, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
	    imagefill($full_id, 0, 0, $trnprt_indx);
	    imagecolortransparent($full_id, $trnprt_indx);
	}

	ImageCopyResampled($full_id, $img, 0, 0, 0, 0, $new_width, $new_height, $FullImage_width, $FullImage_height);


	if(preg_match("/\.(jpg|jpeg)$/", $this->thumb_name))
	{
	    $full = ImageJPEG($full_id, $this->thumb_name, 100);
	}

	if(preg_match("/\.png$/", $this->thumb_name))
	{
	    $full = ImagePNG($full_id, $this->thumb_name);
	}

	if(preg_match("/\.gif$/", $this->thumb_name))
	{
	    $full = ImageGIF($full_id, $this->thumb_name);
	}

	ImageDestroy($full_id);
	unset($max_width);
	unset($max_height);
    }

    public function uploadPicture($maximumSize, $folder, $file, $prefix)
    {
	$this->set_max_size($maximumSize);
	$this->set_directory($folder);
	$this->setFileDetails($file, $prefix);
	$this->start_copy();

	$errorObject = new Error();

	// Control File is uploaded or not
	if($this->is_ok())
	{
	    $this->create_thumbnail(); // create thumbnail
	    $this->set_thumbnail_size(0, 100); // change thumbnail size
	    $extension = explode(".", strtolower($file['name']));
	    $fullImageThumbnail = $this->imageThumbnail.".".$extension[1];

	    $imagePathArray['image'] = $this->user_file_name;
	    $imagePathArray['thumbnail'] = $fullImageThumbnail;

	    $errorObject->setObject($imagePathArray);
	}
	else
	{
	    $error = $this->error();

	    if($error == UploadImage::$FILE_SIZE_ERROR)
	    {
		$errorObject->addError("You can upload images only upto ".number_format(($maximumSize / 1024), 0)." KB");
	    }
	    elseif($error == UploadImage::$FILE_COPY_ERROR)
	    {
		$errorObject->addError("An error occurred while copying the file");
	    }
	    elseif($error == UploadImage::$FILE_EMPTY_ERROR)
	    {
		$errorObject->addError("No file has been uploaded");
	    }
	    elseif($error == UploadImage::$FILE_UPLOAD_ERROR)
	    {
		$errorObject->addError("An error occurred while uploading the file");
	    }
	    else
	    {
		$errorObject->addError("An unknown error occurred. Please try again");
	    }
	}

	return $errorObject;
    }
}

?>
