<?php

class FileUploadUtility
{
	public function __construct()
	{
	}

	public function uploadFile($file, $maxSize, $uploadDir)
	{
		if(!empty($file))
		{
			$fileName = $_FILES[$file]['name'];
			$filetypeArray   = explode(".", $fileName);
			$fileType      = strtolower($filetypeArray[(sizeof($filetypeArray)-1)]);
			$fileSize      = $_FILES[$file]['size'];
			$fileTempName   = $_FILES[$file]['tmp_name'];
			$fileError     = $_FILES[$file]['error'];//file error (if any)

			// ensure that filesize is below or equal to the maxsize (in byte)
			if($fileSize <= $maxSize)
			{
				$fileExist = false; // initialize test... assume file does not exist on server

				while(!$fileExist)
				{
					// generate unique filename to prevent file overwrite
					$fileNewName = strtoupper(preg_replace('/ /','',substr($fileName, 0, -4)))."_".mt_rand(0000000,9999999).".".strtoupper($fileType);
					$filePath = $uploadDir.basename($fileNewName);//set path to check

					// if file not exist, upload the new file
					if(!file_exists($filePath))
					{
						// upload file, update db
						if (move_uploaded_file($fileTempName, $filePath))
						{
							return array("file_name" => $fileName, "file_path" => $filePath);
						}
						else
						{
							return "";
						} // end if upload

						$fileExist = true; // set file exist to break the while loop
					} // end if not file exist
				} // end while

			}
			else
			{
				return "";
			}   // end if maxsize
		} // End if for checking if filename is entered
	}
}

?>