<?php
/**
 * フレームワーク用汎用例外クラス
 *
 * Class PloExceptionArrayMessages
 * @author t-kobayashi
 */

class PloExceptionArrayMessages extends PloException
{
    private $error_array_messages;

    /**
     * PloExceptionArray constructor.
     *
     * エラーメッセージを配列で取得する拡張クラス
     * @param array $error_array_messages
     * @param string $message
     * @param string $error_code
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($error_array_messages=[], $message="", $error_code="", $code=0, Throwable $previous=null) {
        parent::__construct($message="", $error_code="", $code=0, $previous=null);
        $this->error_array_messages = $error_array_messages;
    }

    public function getErrorArray() {
        return $this->error_array_messages;
    }

}
