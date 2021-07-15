<?php
require_once 'Zend/Loader.php';

/**
 * PlottフレームワークデフォルトのAutoloader
 * フロントコントローラーにて読み込むものとする
 * このAutoloaderでロード可能になるクラスは以下の通り
 *
 * + ZendFrameworkのクラス群
 * + lib, ext_lib以下のファイル
 * + Modelファイル
 * + APIファイル
 * + コントローラーファイル
 * + PloService以下に擬似名前空間の形式で設置されたクラス
 *
 */
class PloAutoloader
{
    public static function autoloader($class_name)
    {
        if (strpos($class_name, "Zend") === 0) {
            Zend_Loader::autoload($class_name);
            return 0;
        }
        $file_name = $class_name . ".php";
        if (strpos($class_name, "_API") !== false) {
            $filepath = APP . "/models_api/" . $file_name;
            if (is_readable($filepath)) {
                require $filepath;
                return 0;
            }
            $filename_small = str_replace("_API", "_api", $file_name);
            $filepath_small = APP . "/models_api/" . $filename_small;
            if (is_readable($filepath_small)) {
                require $filepath_small;
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
        $directories = ["models", "lib", "ext_lib"];
        foreach ($directories as $directory) {
            $filepath = APP . "/" . $directory . "/" . $file_name;
            if (is_readable($filepath)) {
                require $filepath;
                return 0;
            }
        }
        return 0;
    }

}
