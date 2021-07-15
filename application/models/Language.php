<?php
/**
 * DB使ってません
 */
require_once APP.'/models_api/Language_api.php';
class Language extends Language_API {

    public function __construct() {
        parent::__construct() ;
    }

    /**
     * @return array
     */
    public function getLanguageMst()
    {
        $this->resetWhere();
        $this->setOrder('language_id');
        $rows = $this->GetList();
        $results = [];
        if ($rows && !empty($rows)) {
            foreach ($rows as $row) {
                array_push(
                    $results,
                    [
                        'language_name' => $row['language_name'],
                        'language_id' => sprintf('%02d', trim($row['language_id']))
                    ]
                );
            }
            return $results;
        }
        // @NOTE 保険で置いておきます。
        return [
            [
                'language_name' => LANGUAGE_NAME_JP_JP,
                'language_id' => '01'
            ],
            [
                'language_name' => LANGUAGE_NAME_EN_EN,
                'language_id' => '02'
            ]
        ];
    }

    /**
     * 空白チェック、フォーマットチェック、存在チェックを行う
     * @param string $paramLanguageId
     * @return string
     */
    public function isExistsLanguageId($paramLanguageId='')
    {
        // 数値以外が含まれる/ 2桁の数字ではない
        $isMatch = preg_match('/[^0-9]+/', $paramLanguageId, $matches);
        if (empty($paramLanguageId) || ($isMatch || count($matches) > 0) || (sprintf('%02d', $paramLanguageId) !== $paramLanguageId)) {
            return false;
        }
        $this->resetWhere();
        $this->setWhere('language_id', $paramLanguageId);
        $rowNum = $this->GetCount();
        if (!$rowNum || $rowNum <= 0) {
            return false;
        }
        return true;
    }
}