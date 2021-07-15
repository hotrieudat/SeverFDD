<?php
/**
 * クラス<br>拡張標準モデル
 *
 * 標準モデルの拡張クラスであり汎用機能を提供する
 *
 * @package   ext_lib
 * @since     2017/01/23
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    takayuki komoda
 */
require_once ('tcpdf/tcpdf.php');
require_once ('fpdi/fpdi.php');

class PloPdf
{

    private $error = false;

    private $message = array();

    private $template = null;

    private $save_file = false;

    private $output = null;

    private $font_name = "kozminproregular";

    private $font_size = 15;

    private $font_color = array(
        "red" => 0,
        "green" => 0,
        "blue" => 0
    );

    private $use_password = false;

    private $password = null;

    private $security = array(
        'print',
        'copy',
        'modify',
        'annot-forms'
    );

    private $watermark = null;

    /**
     * 関数/メソッド<br>初期化
     *
     * テンプレートファイルのパスを指定（必須）
     *
     * @access public
     * @param text $template            
     * @return boolean
     */
    public function setTemplate($template)
    {
        if ($template == "") {
            $this->message[] = "template's file path is null.";
            $this->error = true;
            return false;
        }
        if (! is_file($template)) {
            $this->message[] = "there is no such file '{$template}'.";
            $this->error = true;
            return false;
        }
        $this->template = $template;
        return true;
    }

    /**
     * 関数/メソッド<br>初期化
     *
     * フォント名の指定（デフォルトkozminproregular）
     *
     * @access public
     * @param text $font_name            
     * @return boolean
     */
    public function setFontName($font_name)
    {
        if ($font_name == "") {
            $this->message[] = "font name is null.";
            $this->error = true;
            return false;
        }
        $this->font_name = $font_name;
    }

    /**
     * 関数/メソッド<br>初期化
     *
     * フォントサイズの指定　（デフォルト15）
     *
     * @access public
     * @param text $font_size            
     * @return boolean
     */
    public function setFontSize($font_size)
    {
        if ($font_size == "") {
            $this->message[] = "font size is null.";
            $this->error = true;
            return false;
        }
        if (! is_numeric($font_size)) {
            $this->message[] = "font size is null.";
            $this->error = true;
            return false;
        }
        $this->font_size = $font_size;
    }

    /**
     * 関数/メソッド<br>初期化
     *
     * フォントカラーの指定（デフォルト 0,0,0）
     *
     * @access public
     * @param int $red            
     * @param int $green            
     * @param int $blue            
     * @return boolean
     */
    public function setFontColor($red, $green, $blue)
    {
        if ($red == "" || $green == "" || $blue == "") {
            $this->message[] = "font color is null.";
            $this->error = true;
            return false;
        }
        if (! is_numeric($red) || ! is_numeric($green) || ! is_numeric($blue)) {
            $this->message[] = "font have to be numeric";
            $this->error = true;
            return false;
        }
        if ($red < 0 || $red > 255 || $green < 0 || $green > 255 || $blue < 0 || $blue > 255) {
            $this->message[] = "font have to be between 0 and 255";
            $this->error = true;
            return false;
        }
        $this->font_color = array(
            "red" => $red,
            "green" => $green,
            "blue" => $blue
        );
    }

    /**
     * 関数/メソッド<br>初期化
     *
     * プリントを許可
     *
     * @access public
     */
    public function enablePrint()
    {
        unset($this->security[0]);
    }

    /**
     * 関数/メソッド<br>初期化
     *
     * コピーを許可
     *
     * @access public
     */
    public function enableCopy()
    {
        unset($this->security[1]);
    }

    /**
     * 関数/メソッド<br>初期化
     *
     * 更新を許可
     *
     * @access public
     */
    public function enableModify()
    {
        unset($this->security[2]);
    }

    /**
     * 関数/メソッド<br>初期化
     *
     * フォーム入力を許可
     *
     * @access public
     */
    public function enableForms()
    {
        unset($this->security[3]);
    }

    /**
     * 関数/メソッド<br>初期化
     *
     * パスワードを指定する
     *
     * @access public
     * @param text $password            
     */
    public function usePassword($password = null)
    {
        $this->use_password = true;
        if ($password != null) {
            $this->password = $password;
        } else {
            $this->password = $this->createPassword();
        }
    }

    /**
     * 関数/メソッド<br>初期化
     *
     * 出力先（設定しない場合はPDFを標準出力する）
     *
     * @access public
     * @param text $path            
     */
    public function setOutputFile($path)
    {
        $this->save_file = true;
        $this->output = $path;
    }

    /**
     * 関数/メソッド<br>初期化
     *
     * 透かしにする文字列情報（改行不可・はみ出した部分は表示不能）
     *
     * @access public
     * @param text $watermark            
     */
    public function setWaterMark($watermark)
    {
        $this->watermark = $watermark;
    }

    /**
     * 関数/メソッド<br>PDFを生成
     *
     * モードによりファイルに出力したり標準出力に出力したりする
     *
     * @access public
     * @return boolean
     */
    public function createWaterMark()
    {
        if ($this->error) {
            return false;
        }
        require_once ("tcpdf/tcpdf.php");
        require_once ("fpdi/fpdi.php");
        
        // 暗号化
        
        $pdf = new FPDI();
        $pdf_tmp = new FPDI(); // サイズ取得用にテンポラリを宣言
        
        if ($this->use_password) {
            $password = $this->password;
            $pdf->SetProtection($this->security, $password);
        } else {
            $pdf->SetProtection($this->security);
        }
        $pdf_template = $this->template;
        $pageno = $pdf->setSourceFile($pdf_template);
        $pageno = $pdf_tmp->setSourceFile($pdf_template);
        
        $pdf->SetFont($this->font_name, '', $this->font_size);
        $pdf->SetTextColor($this->font_color['red'], $this->font_color['green'], $this->font_color['blue']);
        $tplidx = 0;
        for ($i = 0; $i < $pageno; $i ++) {
            $tplidx = $pdf_tmp->importPage(($i + 1));
            $pdf_tmp->setPrintHeader(false);
            $pdf_tmp->AddPage();
            $size = $pdf_tmp->useTemplate($tplidx);
            
            $paper_size = $this->getPaperSize($size);
            $orientation = $this->getOrientation($size);
            
            $tplidx = $pdf->importPage(($i + 1));
            $pdf->setPrintHeader(false);
            $pdf->AddPage($orientation, $paper_size);
            $pdf->useTemplate($tplidx);
            $pdf->SetAutoPageBreak(false);
            
            if ($this->watermark != null) {
                $this->addWaterMark($pdf);
            }
        }
        if ($this->save_file) {
            $pdf->Output($this->output, "F");
        } else {
            $pdf->Output();
            exit();
        }
    }

    /**
     * 関数/メソッド<br>パスワード生成
     *
     * 英数小文字8ケタのパスワードを生成し返却する
     *
     * @access private
     *         @params int $length:
     * @return text
     */
    private function createPassword($length = 8)
    {
        // vars
        $pwd = array();
        $pwd_strings = array(
            "sletter" => range('a', 'z'),
            "cletter" => range('A', 'Z'),
            "number" => range('0', '9')
        );
        while (count($pwd) < $length) {
            if (count($pwd) < 3) {
                $key = key($pwd_strings);
                next($pwd_strings);
            } else {
                $key = array_rand($pwd_strings);
            }
            $pwd[] = $pwd_strings[$key][array_rand($pwd_strings[$key])];
        }
        shuffle($pwd);
        
        return implode($pwd);
    }

    /**
     * 関数/メソッド<br>用紙サイズ指定
     *
     * 用紙サイズ指定
     *
     * @access private
     *         @params array $input_size:
     * @return text
     */
    private function getPaperSize($input_size)
    {
        $size = "A4";
        $height = round($input_size["h"], 0);
        $width = round($input_size["w"], 0);
        if ($height == 1189 && $width == 841)
            $size = 'A0';
        if ($height == 841 && $width == 594)
            $size = 'A1';
        if ($height == 594 && $width == 420)
            $size = 'A2';
        if ($height == 420 && $width == 297)
            $size = 'A3';
        if ($height == 297 && $width == 210)
            $size = 'A4';
        if ($height == 210 && $width == 148)
            $size = 'A5';
        if ($height == 148 && $width == 105)
            $size = 'A6';
        if ($height == 105 && $width == 74)
            $size = 'A7';
        if ($height == 74 && $width == 52)
            $size = 'A8';
        if ($height == 52 && $width == 37)
            $size = 'A9';
        if ($height == 37 && $width == 26)
            $size = 'A10';
        if ($height == 26 && $width == 18)
            $size = 'A11';
        if ($height == 18 && $width == 13)
            $size = 'A12';
        if ($height == 1456 && $width == 1030)
            $size = 'B0';
        if ($height == 1030 && $width == 728)
            $size = 'B1';
        if ($height == 728 && $width == 515)
            $size = 'B2';
        if ($height == 515 && $width == 364)
            $size = 'B3';
        if ($height == 364 && $width == 257)
            $size = 'B4';
        if ($height == 257 && $width == 182)
            $size = 'B5';
        if ($height == 182 && $width == 128)
            $size = 'B6';
        if ($height == 128 && $width == 91)
            $size = 'B7';
        if ($height == 91 && $width == 64)
            $size = 'B8';
        if ($height == 64 && $width == 45)
            $size = 'B9';
        if ($height == 45 && $width == 32)
            $size = 'B10';
        if ($height == 32 && $width == 22)
            $size = 'B11';
        if ($height == 22 && $width == 16)
            $size = 'B12';
        if ($width == 1189 && $height = 841)
            $size == 'A0';
        if ($width == 841 && $height = 594)
            $size == 'A1';
        if ($width == 594 && $height = 420)
            $size == 'A2';
        if ($width == 420 && $height = 297)
            $size == 'A3';
        if ($width == 297 && $height = 210)
            $size == 'A4';
        if ($width == 210 && $height = 148)
            $size == 'A5';
        if ($width == 148 && $height = 105)
            $size == 'A6';
        if ($width == 105 && $height = 74)
            $size == 'A7';
        if ($width == 74 && $height = 52)
            $size == 'A8';
        if ($width == 52 && $height = 37)
            $size == 'A9';
        if ($width == 37 && $height = 26)
            $size == 'A10';
        if ($width == 26 && $height = 18)
            $size == 'A11';
        if ($width == 18 && $height = 13)
            $size == 'A12';
        if ($width == 1456 && $height = 1030)
            $size == 'B0';
        if ($width == 1030 && $height = 728)
            $size == 'B1';
        if ($width == 728 && $height = 515)
            $size == 'B2';
        if ($width == 515 && $height = 364)
            $size == 'B3';
        if ($width == 364 && $height = 257)
            $size == 'B4';
        if ($width == 257 && $height = 182)
            $size == 'B5';
        if ($width == 182 && $height = 128)
            $size == 'B6';
        if ($width == 128 && $height = 91)
            $size == 'B7';
        if ($width == 91 && $height = 64)
            $size == 'B8';
        if ($width == 64 && $height = 45)
            $size == 'B9';
        if ($width == 45 && $height = 32)
            $size == 'B10';
        if ($width == 32 && $height = 22)
            $size == 'B11';
        if ($width == 22 && $height = 16)
            $size == 'B12';
        
        return $size;
    }

    /**
     * 関数/メソッド<br>用紙方向指定
     *
     * 用紙方向指定
     *
     * @access private
     *         @params array $input_size:
     * @return text
     */
    private function getOrientation($input_size)
    {
        $operation = "P";
        $height = round($input_size["h"], 0);
        $width = round($input_size["w"], 0);
        if ($height < $width)
            $operation = "L";
        return $operation;
    }

    /**
     * 関数/メソッド<br>スタンプの追加
     *
     * スタンプの追加
     *
     * @access private
     *         @params object $pdf:
     * @return object
     */
    private function addWaterMark($pdf)
    {
        if ($this->watermark == null) {
            return $pdf;
        }
        
        $pdf->SetXY(10, 100);
        $pdf->StartTransform();
        $pdf->Rotate(30);
        $pdf->Cell(0, 10, $this->watermark, 0);
        $pdf->StopTransform();
        
        $pdf->SetXY(10, 200);
        $pdf->StartTransform();
        $pdf->Rotate(30);
        $pdf->Cell(0, 10, $this->watermark, 0);
        $pdf->StopTransform();
        
        $pdf->SetXY(10, 300);
        $pdf->StartTransform();
        $pdf->Rotate(30);
        $pdf->Cell(0, 10, $this->watermark, 0);
        $pdf->StopTransform();
        
        $pdf->SetXY(10, 400);
        $pdf->StartTransform();
        $pdf->Rotate(30);
        $pdf->Cell(0, 10, $this->watermark, 0);
        $pdf->StopTransform();
        
        $pdf->SetXY(110, 100);
        $pdf->StartTransform();
        $pdf->Rotate(30);
        $pdf->Cell(0, 10, $this->watermark, 0);
        $pdf->StopTransform();
        
        $pdf->SetXY(110, 200);
        $pdf->StartTransform();
        $pdf->Rotate(30);
        $pdf->Cell(0, 10, $this->watermark, 0);
        $pdf->StopTransform();
        
        $pdf->SetXY(110, 300);
        $pdf->StartTransform();
        $pdf->Rotate(30);
        $pdf->Cell(0, 10, $this->watermark, 0);
        $pdf->StopTransform();
        
        $pdf->SetXY(110, 400);
        $pdf->StartTransform();
        $pdf->Rotate(30);
        $pdf->Cell(0, 10, $this->watermark, 0);
        $pdf->StopTransform();
        
        $pdf->SetXY(210, 100);
        $pdf->StartTransform();
        $pdf->Rotate(30);
        $pdf->Cell(0, 10, $this->watermark, 0);
        $pdf->StopTransform();
        
        $pdf->SetXY(210, 200);
        $pdf->StartTransform();
        $pdf->Rotate(30);
        $pdf->Cell(0, 10, $this->watermark, 0);
        $pdf->StopTransform();
        
        $pdf->SetXY(210, 300);
        $pdf->StartTransform();
        $pdf->Rotate(30);
        $pdf->Cell(0, 10, $this->watermark, 0);
        $pdf->StopTransform();
        
        $pdf->SetXY(210, 400);
        $pdf->StartTransform();
        $pdf->Rotate(30);
        $pdf->Cell(0, 10, $this->watermark, 0);
        $pdf->StopTransform();
        
        return $pdf;
    }

    /**
     * 関数/メソッド<br>パスワードの取得
     *
     * 設定したパスワードの取得
     *
     * @access public
     * @return text
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * 関数/メソッド<br>メッセージの取得
     *
     * 設定したメッセージの取得（エラー）
     *
     * @access public
     * @return text
     */
    public function getMessage()
    {
        return implode("\n", $this->message);
    }

    /**
     * 関数/メソッド<br>メッセージの取得
     *
     * 設定したメッセージの取得（エラー）
     *
     * @access public
     * @return text
     */
    public function isError()
    {
        return $this->error;
    }
}