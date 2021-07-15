<?php
/**
 * デザイン設定処理
 *
 * @package   PloService/DesignSetting
 * @since     2017/07/26
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    T-Kobayashi
 */

class PloService_DesignSetting_Design
{
    private $params;
    private $files;
    private $model_option;
    private $default_path = '/var/www/public_html/common/image/';
    private $logo_path = '/var/www/public_html/common/image/logo/';
    private $mime_list = [
            "image/gif"                 => "gif",
            "image/jpeg"                => "jpg",
            "image/pjpeg"               => "jpg",
            "image/png"                 => "png",
            "image/x-png"               => "png",
        ];
    private $default = [
            "logo_login_ext"                => "png",
            "logo_login_e_ext"              => "png",
            "logo_header_ext"               => "png",
            "top_background_color"          => "rgb(235, 235, 235)",
            "header_background_color"       => "rgb(29, 131, 149)",// #1D8395
            "global_menu_background_color"  => "rgb(29, 131, 149)",// #1D8395
        ];
    private $file_folder_list = [
            "logo_login_ext" => ["file" => "login_logo", "folder" => "logo1"],
            "logo_login_e_ext" => ["file" => "login_logo_e", "folder" => "logo2"], // 他言語（英語）
            "logo_header_ext" => ["file" => "header_logo", "folder" => "header"],
    ];
    private $user_id;

    /**
     * 登録可能サイズ最大値
     * @var array
     */
    private $maxImgSizes = [
        'logo_login_ext' => ['w'=>385, 'h'=>60],
        'logo_login_e_ext' => ['w'=>385, 'h'=>60],
        'logo_header_ext' => ['w'=>150, 'h'=>28],
    ];

    /**
     * PloService_DesignSetting_Design constructor.
     * @param array $params
     * @param $files
     * @param $user_id
     * @throws Zend_Config_Exception
     */
    public function __construct(array $params, $files, $user_id)
    {
        $this->files = $files;
        $this->model_option = new Option();
        $this->setParameters($params);
        $this->user_id = $user_id;
    }

    /**
     * ファイル有無チェック、メンバ変数格納
     * ファイル名が存在した場合はファイル有り判定
     * @param $params
     */
    private function setParameters($params)
    {
        $this->params['logo'] = [];
        foreach ($this->files as $target => $file) {
            if (empty($file['name'])) {
                continue;
            }
            $this->params['logo'][$target] = $file;
        }
        if (!empty($params['setting_color'])) {
            $this->params['setting_color'] = $params['setting_color'];
        }
    }

    /**
     * For Ajax
     */
    public function _validation()
    {
        $this
            ->isEmpty()
            ->checkFileName()
            ->checkExtension()
            ->moveTemporaryPath()
            ->checkImageScale();
    }

    /**
     * バリデーション、アップデート処理
     * @param bool $default_flag
     * @throws Zend_Config_Exception
     */
    public function update($default_flag=false)
    {
        switch ($default_flag) {
            case false:
                $this
                    ->isEmpty()
                    ->checkFileName()
                    ->checkExtension()
                    ->moveTemporaryPath()
                    ->checkImageScale()
                    ->updateData(false);
                break;
            case true:
            default:
                $this->updateData(true);
                break;
        }
    }

    /**
     * 空チェック
     * @return $this
     */
    private function isEmpty()
    {
        foreach ($this->params['logo'] as $key => $value) {
            if (!empty($value) && $value["size"] !== 0) {
                continue;
            }
            throw new PloException(
                PloWord::convertMessage("##W_SYSTEM_016##")
            );
        }
        return $this;
    }

    /**
     * ファイル名チェック
     * @return $this
     */
    private function checkFileName()
    {
        $inValidChars = ['/', ' ', '　'];
        foreach ($this->params['logo'] as $key => $value) {
            // 置換後の文字列が同一
            if (str_replace($inValidChars, '', $value['name']) == $value['name']) {
                // 含まれていないので問題なし
                continue;
            }
            throw new PloException(
                PloWord::convertMessage("##W_SYSTEM_017##")
            );
        }
        return $this;
    }

    /**
     * 拡張子チェック
     * @return $this
     */
    private function checkExtension()
    {
        foreach ($this->params['logo'] as $key => $value) {
            if (isset($this->mime_list[$value["type"]]) !== false) {
                continue;
            }
            throw new PloException(
                PloWord::convertMessage("##W_SYSTEM_018##")
            );
        }
        return $this;
    }

    /**
     * アップロードファイルの一時領域移動
     * @return $this
     */
    private function moveTemporaryPath()
    {
        foreach ($this->params['logo'] as $file) {
            $temp_file = $this->genTemporaryPath($file['name']);
            $is_success = move_uploaded_file($file["tmp_name"], $temp_file);
            if ($is_success !== false) {
                continue;
            }
            throw new PloException(
                PloWord::convertMessage("##COMMON_ERROR##")
            );
        }
        return $this;
    }

    /**
     * サイズが許容範囲内であることを評価
     * XXX @FIXME サイズが固定である（幅・高さが完全に同じ画像しか認めていない）点は、要検討？
     *
     * @param string $type
     * @param object $file
     * @return bool
     */
    private function isSameImageSizes($type='', $file)
    {
        $temp_file = $this->genTemporaryPath($file['name']);
        $image_scale = getimagesize($temp_file);
        $result = $image_scale[0] === $this->maxImgSizes[$type]['w'] && $image_scale[1] === $this->maxImgSizes[$type]['h'];
        return $result;
    }

    /**
     * テンポラリ領域の画像パス文字列を成形して返却
     * テンポラリ領域が存在しない場合、作成する
     *
     * @param $name
     * @return string
     */
    private function genTemporaryPath($name)
    {
        // Init
        $tmpDir = $this->logo_path . 'tmp/';
        if (!file_exists($tmpDir)) {
            mkdir($tmpDir, 0755);
        }
        $returnPath = $tmpDir . $name;
        return $returnPath;
    }

    /**
     * イメージサイズチェック
     * @return $this
     */
    private function checkImageScale()
    {
        foreach ($this->params['logo'] as $key => $file) {
            $isSameImageSize = $this->isSameImageSizes($key, $file);
            if ($isSameImageSize) {
                continue;
            }
            throw new PloException(
                PloWord::convertMessage("##W_SYSTEM_019##")
            );
        }
        return $this;
    }

    /**
     * 更新リクエストであるか否かにより、rename / copy を切り替えて実施し、更新処理用の配列を返却
     *
     * @param bool $default_flag
     * @return array $set_option
     */
    private function doRenameOrCopy($default_flag=true)
    {
        // Init
        $set_option = [];
        // 更新リクエストではない
        if ($default_flag !== false) {
            // デフォルト設定
            $set_option = $this->default;
            $fileNamesForCopy = [
                ['from' => "login_logo_default.png", 'to' => "logo1/login_logo.png"],
                ['from' => "login_logo_default.png", 'to' => "logo2/login_logo_e.png"], // 他言語（英語）
                ['from' => "logo_default.png", 'to' => "header/header_logo.png"]
            ];
            foreach ($fileNamesForCopy as $u) {
                copy($this->default_path . $u['from'], $this->logo_path . $u['to']);
                chgrp($this->logo_path . $u['to'], 'apache');
                chown($this->logo_path . $u['to'], 'apache');
                chmod($this->logo_path . $u['to'], 0755);
            }
            return $set_option;
        }
        // 更新リクエストである
        foreach ($this->params['logo'] as $key => $file) {
            $fileType = $file['type'];
            $set_option[$key] = $this->mime_list[$fileType];
            if (!empty($this->files[$key])) {
                $tmp_path = $this->genTemporaryPath($file['name']);
                $arrImagePath = [
                    $this->logo_path,
                    $this->file_folder_list[$key]['folder'],
                    '/',
                    $this->file_folder_list[$key]['file'],
                    '.',
                    $this->mime_list[$fileType]
                ];
                $image_path = implode('', $arrImagePath);
                rename($tmp_path, $image_path);
                chgrp($image_path, 'apache');
                chown($image_path, 'apache');
                chmod($image_path, 0755);
            }
        }
        // 値が空である場合に無視する対象
        $ignoreEmptyKeys = ['top_background_color', 'header_background_color', 'global_menu_background_color'];
        if (isset($this->params['setting_color']) && null != $this->params['setting_color'] && !empty($this->params['setting_color'])) {
            foreach ($this->params['setting_color'] as $key => $value) {
                // 値が空であり、そのキーが除外対象である場合
                if (in_array($key, $ignoreEmptyKeys) !== false && empty($value)) {
                    continue;
                }
                $set_option[$key] = $value;
            }
        }
        return $set_option;
    }

    /**
     * DB更新
     * @param bool $default_flag デフォルト設定フラグ
     * @return $this
     * @throws Zend_Config_Exception
     */
    private function updateData($default_flag=true)
    {
        $obj_option = PloService_OptionContainer::getInstance();
        $set_option = $this->doRenameOrCopy($default_flag);
        $this->model_option->begin();
        if (! $this->model_option->UpdateData($set_option)) {
            $this->model_option->rollback();
            throw new PloException(
                PloWord::convertMessage("##E_SYSTEM_008##")
            );
        }
        $this->model_option->commit();
        PloService_Logger_BrowserLogger::logging('06130100', '');
        return $this;
    }

}