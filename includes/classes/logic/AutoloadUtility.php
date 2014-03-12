<?php

/**
 * Description of AutoloadUtility
 *
 * @author suyash
 */
class AutoloadUtility
{

    private $autoloadFile = "autoload.php";

    public function __construct()
    {

    }

    public function createAutoloadFile($directory)
    {
        fopen($directory.$this->autoloadFile, 'w');
    }

    public function generatePage($directory)
    {
        $output = "";

        $output .= $this->generateDisplay($directory);

        $handle = fopen($directory.$this->autoloadFile, 'a');

        fwrite($handle, $output);
    }

    private function getApplicationLink($directory)
    {
        $mainDirectory = str_replace("\\", "\".\$s.\"", $directory);
        $mainDirectory = str_replace("/", "\".\$s.\"", $directory);

        $characterFirst = substr($mainDirectory, 0, 2);

        if($characterFirst == "\".")
        {
            $mainDirectory = substr($mainDirectory, 2, strlen($mainDirectory));
        }

        $lastTwoCharacter = substr($mainDirectory, strlen($mainDirectory) - 2, strlen($mainDirectory));

        if($lastTwoCharacter == ".\"")
        {
            $mainDirectory = substr($mainDirectory, 0, strlen($mainDirectory) - 2);
        }

        //remove last directory separator
        $mainDirectory = substr($mainDirectory, 0, strlen($mainDirectory) - 3);

        return $mainDirectory;
    }

    private function generateDisplay($directory)
    {
        $output = "";

//        $mainDirectory = str_replace("\\", ".\$s.\"", $directory);
//        $mainDirectory = str_replace("/", ".\$s.\"", $directory);

        $mainDirectory = $this->getApplicationLink($directory);

        $output .= "<?php\n";
        $output .= "\n";
        $output .= "function __autoload(\$className)\n";
        $output .= "{\n";
        $output .= "Autoload::init();\n";
        $output .= "Autoload::loadClass(\$className);\n";
        $output .= "}\n";
        $output .= "\n";
        $output .= "class Autoload\n";
        $output .= "{\n";
        $output .= "\n";
        $output .= "private static \$CACHE_FILE = \"\";\n";
        $output .= "private static \$CLASS_FOLDER = \"\";\n";
        $output .= "private static \$OTHER_FOLDER = \"\";\n";
        $output .= "private static \$CACHE_DELETED = false;\n";
        $output .= "\n";
        $output .= "public static function init()\n";
        $output .= "{\n";
        $output .= "\$s = DIRECTORY_SEPARATOR;\n";
        $output .= "\n";
        $output .= "//enter your cache directory here\n";
        $output .= "\$mainDirectory = $mainDirectory;\n";
        $output .= "\n";
        $output .= "Autoload::\$CACHE_FILE = \$mainDirectory.DIRECTORY_SEPARATOR.\"cache\".DIRECTORY_SEPARATOR.\"file_include.txt\";\n";
        $output .= "Autoload::\$CLASS_FOLDER = \$mainDirectory.DIRECTORY_SEPARATOR.\"includes\";\n";
        $output .= "\n";
        $output .= "Autoload::\$OTHER_FOLDER = array();\n";
//        $output .= "Autoload::\$OTHER_FOLDER[0] = \$mainDirectory.DIRECTORY_SEPARATOR.\"PHPMAILER\";\n";
        $output .= "}\n";
        $output .= "\n";
        $output .= "public static function createCacheIncludeFile(\$classFolder)\n";
        $output .= "{\n";
        $output .= "\$fileHandle = fopen(Autoload::\$CACHE_FILE, 'w') or die(\"Could not create cache file\");\n";
        $output .= "\n";
        $output .= "\$pathArray = Autoload::dirTree(Autoload::\$CLASS_FOLDER);\n";
        $output .= "\n";
        $output .= "for(\$i = 0; \$i < count(\$pathArray); \$i++)\n";
        $output .= "{\n";
        $output .= "fwrite(\$fileHandle, \$pathArray[\$i].\"\\n\");\n";
        $output .= "}\n";
        $output .= "\n";
        $output .= "for(\$i=0;\$i<count(Autoload::\$OTHER_FOLDER);\$i++)\n";
        $output .= "{\n";
        $output .= "\$pathArray = Autoload::dirTree(Autoload::\$OTHER_FOLDER[\$i]);\n";
        $output .= "\n";
        $output .= "for(\$j = 0; \$j < count(\$pathArray); \$j++)\n";
        $output .= "{\n";
        $output .= "fwrite(\$fileHandle, \$pathArray[\$j].\"\\n\");\n";
        $output .= "}\n";
        $output .= "}\n";
        $output .= "\n";
        $output .= "fclose(\$fileHandle);\n";
        $output .= "}\n";
        $output .= "\n";
        $output .= "public static function loadClass(\$className)\n";
        $output .= "{\n";
        $output .= "\$classNamePhp = \$className.\".php\";\n";
        $output .= "\$classNamePhp5 = \$className.\".php5\";\n";
        $output .= "\$classNameClassPhp = \$className.\".class.php\";\n";
        $output .= "\$classNameClassPhp5 = \$className.\".class.php5\";\n";
        $output .= "\n";
        $output .= "if(file_exists(Autoload::\$CACHE_FILE))\n";
        $output .= "{\n";
        $output .= "\$cacheFileArray = file(Autoload::\$CACHE_FILE, FILE_IGNORE_NEW_LINES);\n";
        $output .= "\$foundFile = false;\n";
        $output .= "\n";
        $output .= "for(\$i = 0; \$i < count(\$cacheFileArray); \$i++)\n";
        $output .= "{\n";
        $output .= "\$cacheFile = \$cacheFileArray[\$i];\n";
        $output .= "\$position = strrpos(\$cacheFile, DIRECTORY_SEPARATOR) + 1;\n";
        $output .= "\$length = strlen(\$cacheFile) - \$position;\n";
        $output .= "\n";
        $output .= "\$fileName = substr(\$cacheFile, \$position, \$length);\n";
        $output .= "\n";
        $output .= "if((\$fileName == \$classNamePhp) || (\$fileName == \$classNamePhp5) || (\$fileName == \$classNameClassPhp) || (\$fileName == \$classNameClassPhp5))\n";
        $output .= "{\n";
        $output .= "\$foundFile = true;\n";
        $output .= "\n";
        $output .= "require_once \$cacheFile;\n";
        $output .= "return true;\n";
        $output .= "}\n";
        $output .= "}\n";
        $output .= "\n";
        $output .= "if(!\$foundFile && !Autoload::\$CACHE_DELETED)\n";
        $output .= "{\n";
        $output .= "unlink(Autoload::\$CACHE_FILE);\n";
        $output .= "\n";
        $output .= "Autoload::\$CACHE_DELETED = true;\n";
        $output .= "Autoload::loadClass(\$className);\n";
        $output .= "}\n";
        $output .= "}\n";
        $output .= "else\n";
        $output .= "{\n";
        $output .= "Autoload::createCacheIncludeFile(Autoload::\$CLASS_FOLDER);\n";
        $output .= "\n";
        $output .= "Autoload::loadClass(\$className);\n";
        $output .= "}\n";
        $output .= "\n";
        $output .= "return false;\n";
        $output .= "}\n";
        $output .= "\n";
        $output .= "public static function dirTree(\$dir)\n";
        $output .= "{\n";
        $output .= "\$path = '';\n";
        $output .= "\$stack[] = \$dir;\n";
        $output .= "\n";
        $output .= "while(\$stack)\n";
        $output .= "{\n";
        $output .= "\$thisdir = array_pop(\$stack);\n";
        $output .= "\n";
        $output .= "if(\$dircont = scandir(\$thisdir))\n";
        $output .= "{\n";
        $output .= "\$i = 0;\n";
        $output .= "\n";
        $output .= "while(isset(\$dircont[\$i]))\n";
        $output .= "{\n";
        $output .= "if(\$dircont[\$i] !== '.' && \$dircont[\$i] !== '..')\n";
        $output .= "{\n";
        $output .= "\$current_file = \"{\$thisdir}\".DIRECTORY_SEPARATOR.\"{\$dircont[\$i]}\";\n";
        $output .= "\n";
        $output .= "if(is_file(\$current_file))\n";
        $output .= "{\n";
        $output .= "\$ext = pathinfo(\"{\$thisdir}\".DIRECTORY_SEPARATOR.\"{\$dircont[\$i]}\", PATHINFO_EXTENSION);\n";
        $output .= "\n";
        $output .= "if((\$ext == \"php\") || (\$ext == \"php5\"))\n";
        $output .= "{\n";
        $output .= "\$path[] = \"{\$thisdir}\".DIRECTORY_SEPARATOR.\"{\$dircont[\$i]}\";\n";
        $output .= "}\n";
        $output .= "}\n";
        $output .= "elseif(is_dir(\$current_file))\n";
        $output .= "{\n";
        $output .= "\$stack[] = \$current_file;\n";
        $output .= "}\n";
        $output .= "}\n";
        $output .= "\n";
        $output .= "\$i++;\n";
        $output .= "}\n";
        $output .= "}\n";
        $output .= "}\n";
        $output .= "\n";
        $output .= "return \$path;\n";
        $output .= "}\n";
        $output .= "\n";
        $output .= "}\n";
        $output .= "\n";
        $output .= "?>\n";

        return $output;
    }

}

?>
