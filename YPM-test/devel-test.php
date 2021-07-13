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

    /*
    static public function Remove() {

    }
    */
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