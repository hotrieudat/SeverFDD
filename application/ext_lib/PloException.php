<?php
/**
 * フレームワーク用汎用例外クラス
 * 実行時発生例外として定義する
 *
 * @author k-kawanaka
 */

class PloException extends RuntimeException
{
    private $error_code;

    /**
     * PloException constructor.
     * クライアントへ送信するためのエラーコード用メンバを追加
     * Exceptionクラスの標準エラーコード変数が数値のみ使用可能なため拡張
     *
     * @param string $message
     * @param string $error_code
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message="", $error_code="", $code=0, Throwable $previous=null) {
        parent::__construct($message, $code, $previous);
        $this->error_code = $error_code;
    }

    public function getErrorCode() {
        return $this->error_code;
    }

}