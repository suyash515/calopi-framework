<?php

require_once './includes/classes/database/DBQuery.php';

require_once './includes/classes/logic/TableLogicUtility.php';
require_once './includes/classes/logic/FieldLogicUtility.php';
require_once './includes/classes/logic/ScriptGenerator.php';
require_once './includes/classes/logic/ProcessPageUtility.php';
require_once './includes/classes/logic/IndexPageUtility.php';
require_once './includes/classes/logic/AutoloadUtility.php';
require_once './includes/classes/logic/IndexPageClassUtility.php';
require_once './includes/classes/logic/ConfigurationClassUtility.php';

require_once './includes/classes/utilities/TextUtility.php';

/**
 * Description of TableStructureLogicUtility
 *
 * @author suyash.sumaroo
 */
class TableStructureLogicUtility
{

    public function __construct()
    {

    }

    public function generateStructure($directory, $host, $url, $database, $user, $password)
    {
        $connectionParameters = array("host" => $host,
            "username" => $user,
            "password" => $password,
            "database" => $database
        );

        $db = new DBQuery($connectionParameters);

        $databaseStructure = $this->getDatabaseStructure($connectionParameters, $db);

        $this->smartCopy("application_template/", $directory);

        $this->createFiles($databaseStructure, $directory, $host, $url, $database, $user, $password);
    }

    public function getDatabaseStructure($connectionParameters, $db)
    {
        $tableNames = $this->getTableNames($db);

        $tableUtility = array();
        $tableStructure = "";
        $index = "Tables_in_".$connectionParameters["database"];

        for($i = 0; $i < count($tableNames); $i++)
        {
            $tableUtility[$i] = new TableLogicUtility($tableNames[$i][$index]);

            $tableStructure = $this->getTableStructure($tableNames[$i][$index], $db);

            for($j = 0; $j < count($tableStructure); $j++)
            {
                $tableUtility[$i]->addColumn($tableStructure[$j]['Field'], $tableStructure[$j]['Type'],
                        $tableStructure[$j]['Null'], $tableStructure[$j]['Key'], $tableStructure[$j]['Default'],
                        $tableStructure[$j]['Extra']);
            }
        }

        return $tableUtility;
    }

    private function getTableNames($db)
    {
        $query = "SHOW TABLES";
        $result = $db->executeQuery($query);

        return $result;
    }

    private function getTableStructure($table, $db)
    {
        $query = "DESCRIBE $table";
        $result = $db->executeQuery($query);

        return $result;
    }

    private function createFiles($databaseStructure, $directory, $host, $url, $database, $user, $password)
    {
        $this->createDirectories($directory, $databaseStructure);

        $processPageUtility = new ProcessPageUtility();

        $processPageUtility->addHeader($directory, $databaseStructure);

        $indexPageUtility = new IndexPageUtility();
        $indexPageUtility->generatePage($databaseStructure, $directory);

        $autoloadUtility = new AutoloadUtility();
        $autoloadUtility->generatePage($directory);

        ConfigurationClassUtility::generatePage($directory, $host, $url, $database, $user, $password);


        $textUtility = new TextUtility();

        for($i = 0; $i < count($databaseStructure); $i++)
        {
            $name = $textUtility->formatFileName($databaseStructure[$i]->getName());

            //windows
//            $guiName = $directory."includes/classes/gui/".$name."GuiUtility.php";
//            $logicName = $directory."includes/classes/logic/".$name."LogicUtility.php";
            //unix
            $guiName = $directory."includes/classes/gui/model/".$name."GuiUtility.php";
            $logicName = $directory."includes/classes/logic/model/".$name."LogicUtility.php";
            $validatorName = $directory."includes/classes/validator/model/".$name."Validator.php";
            $logicEntityName = $directory."includes/classes/logic/entity/model/".$name."Entity.php";

            $guiHandle = fopen($guiName, 'w');
            fwrite($guiHandle,
                    $databaseStructure[$i]->getGuiClassFunction($name, $databaseStructure[$i]->getName(), $directory));

            $logicHandle = fopen($logicName, 'w');
            fwrite($logicHandle,
                    $databaseStructure[$i]->getLogicClassFunction($name, $databaseStructure[$i]->getName(), $directory));

            $validatorHandle = fopen($validatorName, 'w');
            fwrite($validatorHandle,
                    $databaseStructure[$i]->getValidatorClassFunction($name, $databaseStructure[$i]->getName(),
                            $directory));

            $logicEntityHandle = fopen($logicEntityName, 'w');
            fwrite($logicEntityHandle, $databaseStructure[$i]->getEntityClassFunction($name));

            $processPageUtility->appendAllFunctions($name, $databaseStructure[$i]->getName(), $directory,
                    $databaseStructure[$i]->getFields());
        }

        $processPageUtility->addFooter($directory);
    }

    private function createDirectories($directory, $databaseStructure)
    {
        //windows
//        mkdir($directory."includes");
//        mkdir($directory."includes/classes");
//        mkdir($directory."includes/classes/gui");
//        mkdir($directory."includes/classes/logic");
//        mkdir($directory."includes/js");
        //unix
        mkdir($directory."includes");
        mkdir($directory."includes/classes");
        mkdir($directory."includes/classes/gui");
        mkdir($directory."includes/classes/logic");
        mkdir($directory."includes/js");

        $scriptGenerator = new ScriptGenerator();
        $scriptGenerator->createScriptFile($directory);
        $scriptGenerator->addGlobalVariables($directory);

        $processPageUtility = new ProcessPageUtility();
        $processPageUtility->createProcessFile($directory);

        $indexPageUtility = new IndexPageUtility();
        $indexPageUtility->createIndexFile($directory);

        $autoloadUtility = new AutoloadUtility();
        $autoloadUtility->createAutoloadFile($directory);

        $guiDirectory = $directory."/includes/classes/gui/";

        IndexPageClassUtility::generatePage($databaseStructure, $guiDirectory);
    }

    /**
     * Copy file or folder from source to destination, it can do
     * recursive copy as well and is very smart
     * It recursively creates the dest file or directory path if there weren't exists
     * Situtaions :
     * - Src:/home/test/file.txt ,Dst:/home/test/b ,Result:/home/test/b -> If source was file copy file.txt name with b as name to destination
     * - Src:/home/test/file.txt ,Dst:/home/test/b/ ,Result:/home/test/b/file.txt -> If source was file Creates b directory if does not exsits and copy file.txt into it
     * - Src:/home/test ,Dst:/home/ ,Result:/home/test/** -> If source was directory copy test directory and all of its content into dest
     * - Src:/home/test/ ,Dst:/home/ ,Result:/home/**-> if source was direcotry copy its content to dest
     * - Src:/home/test ,Dst:/home/test2 ,Result:/home/test2/** -> if source was directoy copy it and its content to dest with test2 as name
     * - Src:/home/test/ ,Dst:/home/test2 ,Result:->/home/test2/** if source was directoy copy it and its content to dest with test2 as name
     * @todo
     *     - Should have rollback technique so it can undo the copy when it wasn't successful
     *  - Auto destination technique should be possible to turn off
     *  - Supporting callback function
     *  - May prevent some issues on shared enviroments : http://us3.php.net/umask
     * @param $source //file or folder
     * @param $dest ///file or folder
     * @param $options //folderPermission,filePermission
     * @return boolean
     */
    private function smartCopy($source, $dest, $options = array('folderPermission' => 0777, 'filePermission' => 0777))
    {
        $result = false;

        if(is_file($source))
        {
            if($dest[strlen($dest) - 1] == '/')
            {
                if(!file_exists($dest))
                {
                    cmfcDirectory::makeAll($dest, $options['folderPermission'], true);
                }
                $__dest = $dest."/".basename($source);
            }
            else
            {
                $__dest = $dest;
            }
            $result = copy($source, $__dest);
            chmod($__dest, $options['filePermission']);
        }
        elseif(is_dir($source))
        {
            if($dest[strlen($dest) - 1] == '/')
            {
                if($source[strlen($source) - 1] == '/')
                {
                    //Copy only contents
                }
                else
                {
                    //Change parent itself and its contents
                    $dest = $dest.basename($source);
                    @mkdir($dest);
                    chmod($dest, $options['filePermission']);
                }
            }
            else
            {
                if($source[strlen($source) - 1] == '/')
                {
                    //Copy parent directory with new name and all its content
                    @mkdir($dest, $options['folderPermission']);
                    chmod($dest, $options['filePermission']);
                }
                else
                {
                    //Copy parent directory with new name and all its content
                    @mkdir($dest, $options['folderPermission']);
                    chmod($dest, $options['filePermission']);
                }
            }

            $dirHandle = opendir($source);

            while($file = readdir($dirHandle))
            {
                if($file != "." && $file != "..")
                {
                    if(!is_dir($source."/".$file))
                    {
                        $__dest = $dest."/".$file;
                    }
                    else
                    {
                        $__dest = $dest."/".$file;
                    }
                    //echo "$source/$file ||| $__dest<br />";
                    $result = $this->smartCopy($source."/".$file, $__dest, $options);
                }
            }

            closedir($dirHandle);
        }
        else
        {
            $result = false;
        }

        return $result;
    }

}

?>
