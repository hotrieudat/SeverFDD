<?php

/**
 * Class PloExcel
 * PHPExcel ラッパー関数
 */

class PloExcel
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var PHPExcel_IOFactory
     */
    private $objPExcel;

    /**
     * Setter
     * @param $path エクセルのファイルパス
     *
     * @throws PHPExcel_Reader_Exception
     */
    public function setting($path)
    {
        $this->path = $path;
        require_once '/var/www/library/PHPExcel/Classes/PHPExcel/IOFactory.php';
        if (!file_exists($this->path)) {
            throw new Exception("{$this->path} is not found.");
        }
        $defaultPrecision = ini_get('precision');
        error_reporting(0);
        $this->objPExcel = PHPExcel_IOFactory::load($this->path);
        error_reporting(E_ALL);
        ini_set('precision', $defaultPrecision);
    }

    /**
     * PHPExcel で操作しているシートの情報を取得する関数
     * @return mixed
     */
    public function getActiveSheet()
    {
        error_reporting(0);
        $result = $this->objPExcel->getActiveSheet()->toArray(null, true, true, true);
        error_reporting(E_ALL);
        return $result;

    }

    /**
     * 引数で渡したシートの情報を取得する関数
     * @param $sheet_name
     *
     * @return mixed
     * @todo PHPDoc のコメントは要検証（コメント記載者コードについて把握しておらず）
     */
    public function getSheetByName($sheet_name)
    {
        error_reporting(0);
        $result = $this->objPExcel->getSheetByName($sheet_name)->toArray(null, true, true, true);
        error_reporting(E_ALL);
        return $result;
    }

    /**
     * シート名を取得する関数
     * @return mixed
     */
    public function getSheetNames()
    {
        error_reporting(0);
        $result = $this->objPExcel->getSheetNames();
        error_reporting(E_ALL);
        return $result;
    }

}