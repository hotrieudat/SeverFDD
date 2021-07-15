<?php
require_once 'Zend/Loader.php';

class PloAutoloader
{

    public static function autoloader($class_name)
    {
        if (strpos($class_name, "Zend") === 0) {
            Zend_Loader::autoload($class_name);
            return 0;
        }
        $file_name = $class_name . ".php";
        if (strpos($class_name, "_API") !== false || strpos($class_name, "_api") !== false) {
            $filepath = APP . "/models_api/" . $file_name;
            if (is_readable($filepath)) {
                require $filepath;
                return 0;
            }
            $lower_filepath = str_replace("_API.php", "_api.php", $filepath);
            if (is_readable($lower_filepath)) {
                require $lower_filepath;
                return 0;
            }
        }
        if (strpos($class_name, "Controller") !== false) {
            $filepath = APP . "/controllers/" . $file_name;
            if (is_readable($filepath)) {
                require $filepath;
                return 0;
            }
        }
        if (strpos($class_name, "Plo") === 0) {
            $filepath = APP . "/lib/" . $file_name;
            if (is_readable($filepath)) {
                require $filepath;
                return 0;
            }
        }
        if (strpos($class_name, "PloService") === 0) {
            Zend_Loader::loadClass($class_name, APP);
        }
        $directories = [
            "models",
            "lib",
            "ext_lib"
        ];
        foreach ($directories as $directory) {
            $filepath = APP . "/" . $directory . "/" . $file_name;
            if (is_readable($filepath)) {
                require $filepath;
                return 0;
            }
        }
    }
}
