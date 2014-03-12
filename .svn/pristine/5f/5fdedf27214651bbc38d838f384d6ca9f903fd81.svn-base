<?php

function __autoload($className)
{
    Autoload::init();
    Autoload::loadClass($className);
}

class Autoload
{

    private static $CACHE_FILE = "";
    private static $CLASS_FOLDER = "";
    private static $OTHER_FOLDER = "";
    private static $CACHE_DELETED = false;

    public static function init()
    {
        $s = DIRECTORY_SEPARATOR;

        //enter your cache directory here
        $mainDirectory = "#enter_directory_here";

        Autoload::$CACHE_FILE = $mainDirectory.DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR."file_include.txt";
        Autoload::$CLASS_FOLDER = $mainDirectory.DIRECTORY_SEPARATOR."includes";

        Autoload::$OTHER_FOLDER = array();
        Autoload::$OTHER_FOLDER[count(Autoload::$OTHER_FOLDER)] = $mainDirectory.DIRECTORY_SEPARATOR."libraries";
    }

    public static function createCacheIncludeFile($classFolder)
    {
        $fileHandle = fopen(Autoload::$CACHE_FILE, 'w') or die("Could not create cache file");

        $pathArray = Autoload::dirTree(Autoload::$CLASS_FOLDER);

        for($i = 0; $i < count($pathArray); $i++)
        {
            fwrite($fileHandle, $pathArray[$i]."\n");
        }

        for($i = 0; $i < count(Autoload::$OTHER_FOLDER); $i++)
        {
            $pathArray = Autoload::dirTree(Autoload::$OTHER_FOLDER[$i]);

            for($j = 0; $j < count($pathArray); $j++)
            {
                fwrite($fileHandle, $pathArray[$j]."\n");
            }
        }

        fclose($fileHandle);
    }

    public static function loadClass($className)
    {
        $classNamePhp = $className.".php";
        $classNamePhp5 = $className.".php5";
        $classNameClassPhp = $className.".class.php";
        $classNameClassPhp5 = $className.".class.php5";

        if(file_exists(Autoload::$CACHE_FILE))
        {
            $cacheFileArray = file(Autoload::$CACHE_FILE, FILE_IGNORE_NEW_LINES);
            $foundFile = false;

            for($i = 0; $i < count($cacheFileArray); $i++)
            {
                $cacheFile = $cacheFileArray[$i];
                $position = strrpos($cacheFile, DIRECTORY_SEPARATOR) + 1;
                $length = strlen($cacheFile) - $position;

                $fileName = substr($cacheFile, $position, $length);

                if(($fileName == $classNamePhp) || ($fileName == $classNamePhp5) || ($fileName == $classNameClassPhp) || ($fileName == $classNameClassPhp5))
                {
                    $foundFile = true;

                    require_once $cacheFile;
                    return true;
                }
            }

            if(!$foundFile && !Autoload::$CACHE_DELETED)
            {
                unlink(Autoload::$CACHE_FILE);

                Autoload::$CACHE_DELETED = true;
                Autoload::loadClass($className);
            }
        }
        else
        {
            Autoload::createCacheIncludeFile(Autoload::$CLASS_FOLDER);

            Autoload::loadClass($className);
        }

        return false;
    }

    public static function dirTree($dir)
    {
        $path = '';
        $stack[] = $dir;

        while($stack)
        {
            $thisdir = array_pop($stack);

            if($dircont = scandir($thisdir))
            {
                $i = 0;

                while(isset($dircont[$i]))
                {
                    if($dircont[$i] !== '.' && $dircont[$i] !== '..')
                    {
                        $current_file = "{$thisdir}".DIRECTORY_SEPARATOR."{$dircont[$i]}";

                        if(is_file($current_file))
                        {
                            $ext = pathinfo("{$thisdir}".DIRECTORY_SEPARATOR."{$dircont[$i]}", PATHINFO_EXTENSION);

                            if(($ext == "php") || ($ext == "php5"))
                            {
                                $path[] = "{$thisdir}".DIRECTORY_SEPARATOR."{$dircont[$i]}";
                            }
                        }
                        elseif(is_dir($current_file))
                        {
                            $stack[] = $current_file;
                        }
                    }

                    $i++;
                }
            }
        }

        return $path;
    }

}

?>