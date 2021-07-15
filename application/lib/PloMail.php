<?php

/**
 * クラス<br>メール
 *
 * メール送信全般を汎用化
 *
 * @package   PlottFramework
 * @since     2014/11/07
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    takayuki komoda
 */
class PloMail
{

    /**
     * メール送信関数
     *
     * 添付ファイルをつける場合は、以下２パターンの引数を利用してください
     *
     * パターン1. 添付するファイルが同一ディレクトリにある
     *  $file_arr に添付するファイル名を配列で渡す
     *  $file_dir にファイルがあるサーバーのパスを渡す
     *
     * パターン2. ※要確認※ 添付するファイルが複数のディレクトリにある
     *  $file_arr に添付するファイルの絶対パスを配列で渡す
     *  $file_dir は "" で固定
     *
     * @access  static
     *
     * @param string $to
     * @param string $from
     * @param string $return_path
     * @param string $subject
     * @param string $message
     * @param array  $file_arr メールに添付するファイルのファイル名
     * @param string $file_dir メールに添付するファイルが格納されているファイルパス
     *
     * @return  boolean
     */
    static function sendMail(
        $to,
        $from,
        $return_path,
        $subject,
        $message,
        $file_arr = array(),
        $file_dir = null
    )
    {

        $from_address = null;
        $from_text = null;

        mb_language("uni");
        mb_internal_encoding("UTF-8");

        $from_arr = self::getEmails($from);

        //改行処理(すべてLFコードに統一）
        $message = mb_ereg_replace("\r\n", "\n", $message);
        $message = mb_ereg_replace("\r", "\n", $message);

        if (count($from_arr) == 0) {
            $err = true;
        } elseif (count($from_arr) == 1) {
            $from_address = $from_arr[0];
            $from_text = str_replace("<" . $from_address . ">", "", $from, $change_count);

            if ($change_count == 0) {
                $from_text = null;
            } else {
            }
        } else {
            $err = true;
        }

        $from_mime = mb_encode_mimeheader($from_text, 'UTF-8', "B", "\n") . "<" . $from_address . ">";

        $header = "From: " . $from_mime . "\n";
        $header .= "MIME-Version: 1.0\n";
        $header .= "Content-Type: multipart/mixed; boundary=\"__PHPRECIPE__\"\n";

        $subject = mb_encode_mimeheader($subject, 'UTF-8', "B", "\n");

        $body = "--__PHPRECIPE__\n";
        $body .= "Content-Type: text/plain; charset=\"UTF-8\"\n";
        $body .= "\n";
        $body .= $message . "\n";

        $finfo = finfo_open(FILEINFO_MIME);
        // 添付ファイルへの処理をします。
        for ($i = 0; $i < count($file_arr); $i++) {
            $body .= "--__PHPRECIPE__\n";
            $handle = fopen($file_dir . $file_arr[$i], 'r');
            $attachFile = fread($handle, filesize($file_dir . $file_arr[$i]));
            fclose($handle);
            // MIMEタイプを取得
            $mime_type = finfo_file($finfo, $file_dir . $file_arr[$i]);

            if (preg_match("/^application\/(?:x-|)zip/", $mime_type)) {
                $extension_tmp = explode(".", $file_arr[$i]);
                $extention = $extension_tmp[count($extension_tmp) - 1];
                switch ($extention) {
                    case "docx":
                        $mime_type = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
                        break;
                    case "docm":
                        $mime_type = "application/vnd.ms-word.document.macroEnabled.12";
                        break;
                    case "dotx":
                        $mime_type = "application/vnd.openxmlformats-officedocument.wordprocessingml.template";
                        break;
                    case "dotm":
                        $mime_type = "application/vnd.ms-word.template.macroEnabled.12";
                        break;
                    case "xlsx":
                        $mime_type = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
                        break;
                    case "xlsm":
                        $mime_type = "application/vnd.ms-excel.sheet.macroEnabled.12";
                        break;
                    case "xltx":
                        $mime_type = "application/vnd.openxmlformats-officedocument.spreadsheetml.template";
                        break;
                    case "xltm":
                        $mime_type = "application/vnd.ms-excel.template.macroEnabled.12";
                        break;
                    case "xlsb":
                        $mime_type = "application/vnd.ms-excel.sheet.binary.macroEnabled.12";
                        break;
                    case "xlam":
                        $mime_type = "application/vnd.ms-excel.addin.macroEnabled.12";
                        break;
                    case "pptx":
                        $mime_type = "application/vnd.openxmlformats-officedocument.presentationml.presentation";
                        break;
                    case "pptm":
                        $mime_type = "application/vnd.ms-powerpoint.presentation.macroEnabled.12";
                        break;
                    case "ppsx":
                        $mime_type = "application/vnd.openxmlformats-officedocument.presentationml.slideshow";
                        break;
                    case "ppsm":
                        $mime_type = "application/vnd.ms-powerpoint.slideshow.macroEnabled.12";
                        break;
                    case "potx":
                        $mime_type = "application/vnd.openxmlformats-officedocument.presentationml.template";
                        break;
                    case "potm":
                        $mime_type = "application/vnd.ms-powerpoint.template.macroEnabled.12";
                        break;
                    case "ppam":
                        $mime_type = "application/vnd.ms-powerpoint.addin.macroEnabled.12";
                        break;
                    case "sldx":
                        $mime_type = "application/vnd.openxmlformats-officedocument.presentationml.slide";
                        break;
                    case "sldm":
                        $mime_type = "application/vnd.ms-powerpoint.slide.macroEnabled.12";
                        break;
                    case "one":
                        $mime_type = "application/onenote";
                        break;
                    case "onetoc2":
                        $mime_type = "application/onenote";
                        break;
                    case "onetmp":
                        $mime_type = "application/onenote";
                        break;
                    case "onepkg":
                        $mime_type = "application/onenote";
                        break;
                    case "thmx":
                        $mime_type = "application/vnd.ms-officetheme";
                        break;
                    default:
                }
            }


            $attachEncode = base64_encode($attachFile);
            $body .= "Content-Type: " . $mime_type . ";\n";
            $body .= " name=\"\n ";
            $body .= mb_encode_mimeheader($file_arr[$i], 'UTF-8', "B", "\n") . "\"\n";
            $body .= "Content-Transfer-Encoding: base64\n";
            $body .= "Content-Disposition: attachment;\n";
            $body .= " file_name=\"\n ";
            $body .= mb_encode_mimeheader($file_arr[$i], 'UTF-8', "B", "\n") . "\"\n";
            $body .= "\n";
            $body .= chunk_split($attachEncode, "76", "\n") . "\n";
        }
        $body .= "--__PHPRECIPE__--\n";

        $to = self::encodeRecipients($to);
        // メールの送信と結果の判定をします。セーフモードがOnの場合は第5引数が使えません。
        if (ini_get('safe_mode')) {
            $result = mail($to, $subject, $body, $header);
        } else {
            $result = mail($to, $subject, $body, $header, '-f' . $return_path);
        }

        return $result;
    }

    /**
     * 配列形式の引数でメールを送る処理
     *
     * 本メソッドでは添付ファイルはつけられません。
     *
     * @param $data
     *
     * @return bool
     * @see PloMail::sendMail()
     *
     */
    static function sendMailArray($data)
    {

        return self::sendMail(
            $data["to"],
            $data["from"],
            $data["return_path"],
            $data["subject"],
            $data["messsage"]
        );
    }

    /**
     * テキストデータよりメールアドレスを配列で返す処理
     * メールアドレスに該当する箇所が複数ある場合、最初にマッチしたものだけを返す
     *
     * @access  static
     *
     * @param string $text
     *
     * @return  array
     */
    static function getEmails($text)
    {
        $email_regex_pattern = '/(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|"[^\\\\\x80-\xff\n\015"]*(?:\\\\[^\x80-\xff][^\\\\\x80-\xff\n\015"]*)*")(?:\.(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|"[^\\\\\x80-\xff\n\015"]*(?:\\\\[^\x80-\xff][^\\\\\x80-\xff\n\015"]*)*"))*@(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\\\x80-\xff\n\015\[\]]|\\\\[^\x80-\xff])*\])(?:\.(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\\\x80-\xff\n\015\[\]]|\\\\[^\x80-\xff])*\]))*/';
        if (preg_match_all($email_regex_pattern, $text, $matches, PREG_PATTERN_ORDER)) {
            if (isset($matches[0])) {
                $matches[0] = array_reverse($matches[0]);
                foreach ($matches[0] as $value) {
                    $result = filter_var($value, FILTER_VALIDATE_EMAIL);
                    if ($result !== false) {
                        return array($result);
                    }
                }
            }
        }
        return array();
    }

    /**
     * sendMail の $to で渡された文字列から メールアドレス部分だけを抽出する処理
     *
     * $to に xxxx@xxxx.com <YYYYYY> という値が入ることを想定
     *
     * @param $to
     *
     * @return string
     * @see PloMail::sendMail()
     */
    private static function encodeRecipients($to)
    {
        $to_arr = explode(",", $to);
        $encoded_recipients = array();
        foreach ($to_arr as $raw_to) {
            $trimmed_raw_to = trim($raw_to);
            if (preg_match("/(.*)<(.*)>/", $trimmed_raw_to, $matches) != 1) {
                $encoded_recipients[] = $trimmed_raw_to;
                continue;
            }
            $name = $matches[1];
            $address = $matches[2];
            $encoded_recipients[] = mb_encode_mimeheader($name) . "<{$address}>";
        }
        return implode(",", $encoded_recipients);
    }

}
