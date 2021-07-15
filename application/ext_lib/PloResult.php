<?php

/**
 * 従来のresultxml.tplを置き換えるクラス
 * Ajax通信の際の結果を表すクラス
 *
 * @author k-kawanaka
 *
 */
class PloResult
{

    /**
     *
     * @var string[] メッセージ配列
     */
    private $messages;

    /**
     *
     * @var string[] Debug用メッセージ配列
     */
    private $debug_messages;

    /**
     *
     * @var bool trueなら成功、falseなら失敗
     */
    private $status;

    /**
     *
     * @var array ["target_id" => "表示DOMID", "message" => "表示エラーメッセージ"] の連想配列の配列
     */
    private $error_messages;

    /**
     * 通信固有のメッセージなど
     *
     * @var array ["key" => "data"]
     */
    private $custom_data = [];

    public function __construct()
    {}

    /**
     * メッセージをセット
     *
     * @param string|string[] $messages
     *            追加するメッセージ 文字列でも文字列配列でも可
     * @return PloResult 自身のオブジェクト
     */
    public function setMessage($messages)
    {
        if ($this->messages === null) {
            $this->messages = [];
        }
        if (is_array($messages)) {
            $this->messages = array_merge($this->messages, $messages);
        } else {
            $this->messages[] = $messages;
        }
        return $this;
    }

    /**
     * @param null $key
     * @return string|string[]
     */
    public function getMessage($key=null)
    {
        return ($key == null) ? $this->messages : $this->messages[$key];
    }

    /**
     * @param null $key
     */
    public function removeMessage($key=null)
    {
        if ($key == null) {
            // reset
            $this->messages = [];
        } else {
            $this->messages[$key] = null;
        }
    }


    /**
     * デバッグ用メッセージをセット
     *
     * @param string|string[] $messages
     *            メッセージ 文字列でも文字列配列でも可
     * @return PloResult 自身のオブジェクト
     */
    public function setDebugMessages($messages)
    {
        if ($this->debug_messages === null) {
            $this->debug_messages = [];
        }
        if (is_array($messages)) {
            $this->debug_messages = array_merge($this->debug_messages, $messages);
        } else {
            $this->debug_messages[] = $messages;
        }
        return $this;
    }

    /**
     * ステータスをセット
     *
     * @param bool $status
     *            trueなら成功、falseなら失敗
     * @return PloResult 自身のオブジェクト
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * DOMに書き込むエラーメッセージをセット
     *
     * @param string $id
     *            DOMのID HTMLでは前に"error_"が付いている必要がある
     *            【例】$idがuser_nameの場合,出力HTMLのDOMは <span id="error_user_name">など
     * @param string $message
     *            表示するメッセージ
     * @return PloResult 自身のオブジェクト
     */
    public function setErrorMessage($id, $message)
    {
        $this->error_messages[] = [
            "target_id" => $id,
            "message" => $message
        ];
        return $this;
    }

    /**
     * DOMに書き込むエラーメッセージを連想配列でセット
     *
     * @param array $errors
     *            DOM ID => エラーメッセージ の連想配列
     * @return PloResult 自身のオブジェクト
     */
    public function setErrorMessages($errors)
    {
        foreach ($errors as $id => $message) {
            $this->error_messages[] = [
                "target_id" => $id,
                "message" => $message
            ];
        }
        return $this;
    }

    /**
     * 通信固有のカスタムデータをセット
     *
     * @param string $key
     *            データのキー
     * @param mixed $data
     *            格納するデータ 形式は問わない
     * @return PloResult 自身のオブジェクト
     */
    public function setCustomData($key, $data)
    {
        $this->custom_data[$key] = $data;
        return $this;
    }

    /**
     * 自身をJSONとして出力
     *
     * @throws PloException statusがセットされていない状態でコールされたとき
     * @return string 自身をJSON化したもの
     */
	public function put()
	{
		if (is_null($this->status)) {
			throw new PloException("ステータスがセットされておりません");
		}
		$json = [];
		foreach ($this as $key => $value) {
			$json[$key] = empty($value) ? null : $value;
		}
		$json["status"] = $this->status;
		return json_encode($json);
    }

	/**
	 * エラーメッセージを出力
	 * @return array|bool
	 */
	public function getErrorMessages()
	{
		$rtn_data = [];
		foreach ($this as $key => $value) {
			$rtn_data[$key] = empty($value) ? null : $value;
		}
		if (empty($rtn_data['messages'])) {
			return true;
		}
		return $rtn_data;
	}

}
