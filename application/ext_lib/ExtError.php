<?php
/**
 * バリデーション結果管理
 *
 * @package   Ploservice
 * @since     2018/01/23
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    Takuma Kobayashi
 */

class ExtError
{

    /**
     * エラーフラグ
     * @var bool
     */
    private $is_error;

    /**
     * エラーメッセージ
     * @var string
     */
    private $error_message;

    /**
     * Validator constructor.
     */
    public function __construct()
    {
        $this->is_error = false;
        $this->error_message = null;
    }

    /**
     * エラーフラグゲッタ
     * @return bool
     */
    public function getError()
    {
        return $this->is_error;
    }

    /**
     * エラーフラグセッタ
     */
    public function setError()
    {
        $this->is_error = true;
    }

    /**
     * エラーメッセージゲッタ
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->error_message;
    }

    /**
     * エラーメッセージセッタ
     * @param $error_message
     */
    public function setErrorMessage($error_message)
    {
        if (is_array($error_message)) {
            foreach ($error_message as $message) {
                $this->error_message[] = $message;
            }
        } else {
            $this->error_message[] = $error_message;
        }
    }

}