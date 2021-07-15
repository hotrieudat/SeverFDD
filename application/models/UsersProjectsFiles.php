<?php
class UsersProjectsFiles extends UsersProjectsFiles_api
{
    /**
     * File_mstの最大値で指定された桁数のランダムな文字列の作成
     *
     * @return string
     */
    static function createRandomFilePassword()
    {
        return strtr(substr(base64_encode(openssl_random_pseudo_bytes(214)), 0, 214), '/+', '_-');
    }

    /**
     * @param $param
     * @return array|bool|int
     */
    public function getRow_byParentCodes($param)
    {
        $this->resetWhere();
        $this->setWhere('user_id', $param['user_id']);
        $this->setWhere('project_id', $param['project_id']);
        $this->setWhere('file_id', $param['file_id']);
        $isExists = $this->getOne();
        if (!$isExists || empty($isExists)) {
            return [];
        }
        return $isExists;
    }

    /**
     * application/controllers/ProjectsFilesController.php -> judgeAndMoldThreshold で
     * 閾値判定などを行った結果として、書き換える対象が存在する場合
     * 対象のキー値と、更新値が配列に代入しており、
     * application/controllers/ProjectsFilesController.php -> execupdateAction から呼び出し
     * その配列を受け取り、更新処理を実行
     *
     * @param array $targets
     * @return int
     */
    public function correctTheValues_byPrimaryKeys($targets=[])
    {
        foreach ($targets as $target) {
            $this->resetWhere();
            $this->setWhere('user_id', $target['user_id']);
            $this->setWhere('project_id', $target['project_id']);
            $this->setWhere('file_id', $target['file_id']);
            $result = $this->UpdateData(['usage_count_limit_minus_remaining' => $target['usage_count_limit_minus_remaining']]);
            if (!$result) {
                PloError::SetErrorMessage(['update error']);
                PloError::SetError();
                return 0;
            }
        }
        // System エラーでなく処理さえ抜けていれば true
        return 1;
    }

    /**
     * @param $user_id
     * @param $project_id
     * @param $file_id
     * @return array|bool|int
     */
    public function getRow_byUserId_andProjectId_andFileId($user_id, $project_id, $file_id)
    {
        $this->resetWhere();
        $this->setWhere('user_id', $user_id);
        $this->setWhere('project_id', $project_id);
        $this->setWhere('file_id', $file_id);
        $row = $this->getOne();
        if (!$row || empty($row)) {
            return [];
        }
        return $row;
    }

    /**
     * @param $user_id
     * @param $project_id
     * @param $file_id
     * @param $data
     */
    public function updateOne_byUserId_andProjectId_andFileId($user_id, $project_id, $file_id, $data)
    {
        $this->setWhere('user_id', $user_id);
        $this->setWhere('project_id', $project_id);
        $this->setWhere('file_id', $file_id);
        $this->UpdateOne($data);
    }

    /**
     * @param $user_id
     * @param $project_id
     * @param $file_id
     */
    public function deleteRows_byUserId_andProjectId_andFileId($user_id, $project_id, $file_id)
    {
        $this->resetWhere();
        $this->setWhere('user_id', $user_id);
        $this->setWhere('project_id', $project_id);
        if (isset($file_id) && !empty($file_id)) {
            $this->setWhere('file_id', $file_id);
        }
        $this->DeleteData();
    }
}