#!/usr/bin/php
<?php
//ypm-module-v1
$YPM_VER = "v1";

//ypm:packages:backend:start

//ypm:package:backend:crime:1.0.0:start
//ypm:package:backend:end

//ypm:packages:backend:end

/*
! Yeet Package Manager
* -------------------------------
? This shit may cause cancer
? Writing this made me wanna kill
? myself          -Matic 
*/
class YPM
{
    /*
        finds a package with $name in the file $src (path to a local file or url to a server)
        copies it into the apropriate section in *this* file

        there are 2 sections in a file 
        `backend` and `frontend` 
        (frontend packages get inserted into the main rendered document,
         backend code gets inserted at the top or below the package manager code)

        a section starts with `//ypm:packages:<section>:start`
        and ends with         `//ypm:packages:<section>:end`

        between theese 2 lines there are packages

        a package starts with //ypm:package:<section>:<name>:<version>:start
        and ends with         //ypm:package:<section>:end

        the section part exists only so we know where to insert the module; it's only used internally

        so to install / update a package we:
        
        1. download/open the src file
        2. find a module by name (similar code can be found in RemovePackage)
        3. parse the section name
        4. find the section in *this* file
        5. insert the module and write the changes

    */
    static public function InstallPackage($src,$name) {

    }

    static public function GetPackages()
    {
        $file = file_get_contents(__FILE__); //read the source code of the current file

        //regex=POG
        $matches = [];
        preg_match_all("/\/\/ypm:package:(\w*):([a-z0-9\-\_]*):([0-9\.]*):start/", $file, $matches);

        $output = [];

        for ($i = 0; $i < count($matches[0]); $i++) {
            $output[] = array(
                "name" => $matches[2][$i],
                "place" => $matches[1][$i],
                "version" => $matches[3][$i]
            );
        }

        return $output;
    }

    static public function RemovePackage($name)
    {
        echo $name;

        $source_code = file_get_contents(__FILE__); //read the source code of the current file

        $regex = join(["/(\/\/ypm:package:\w*:",$name,":[0-9\.]*:start)(.{1,}?)(\/\/ypm:package:\w*:end)/s"]); 
        $source_code = preg_replace($regex, "", $source_code); //remove the package

        $handle = fopen(__FILE__, "w");
        fwrite($handle, $source_code); //write the new source code
        fclose($handle);
    }
}

class FuckYouException extends Exception
{
};

function cli($argv)
{
    //parse the args

    if (count($argv) > 1) {
        switch ($argv[1]) {
            case "ypm-list": {
                    $pkgs = YPM::GetPackages();
                    foreach ($pkgs as $pkg) {
                        echo join([$pkg["place"], ":", $pkg["name"], " @ ", $pkg["version"], "\n"]);
                    }
                }
                break;
            case "ypm-add": {
                }
                break;
            case "ypm-remove": {
                    if (count($argv) != 3) {
                        echo "invalid";
                        throw new FuckYouException();
                    } else {
                        YPM::RemovePackage($argv[2]);
                    }
                }
                break;
            default:
                echo "invalid option\nypm-list | ypm-add <package name> <source> | ypm-remove <package name>\n";
                break;
        }
    } else {
        throw new FuckYouException("invalid usage fuck off u useless piece of shit; KYS!\n");
    }
}

$is_cli = php_sapi_name() == "cli";
if (!$is_cli)
    ob_clean(); // get rid of the shebang
else
    cli($argv);

?>