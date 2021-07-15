<?php

class UserGroupsUsersForProjectsParticipant extends UserGroupsUsersForProjectsParticipant_api
{
    /**
     * ユーザーデータ
     * @var array
     */
    private $user_data;

    /**
     * ユーザーデータセッタ
     *
     * @param $data array
     * @return $this
     */
    public function setUserData($data)
    {
        $this->user_data = $data;
        return $this;
    }

    /**
     * 重複チェック
     *
     * @param $tags_data array
     * @return $this
     */
    public function duplicateTags($tags_data) {
        $cnt = 0;
        $succeed = [];
        foreach ($tags_data as $data) {
            if ($cnt !== 0) {
                foreach ($succeed as $tag_id) {
                    if ($tag_id === $data) {
                        throw new PloExceptionArrayMessages(['重複したタグは登録できません。']);
                    }
                }
            }
            $cnt++;
            $succeed[] = $data;
        }
        return $this;
    }

    /**
     * バリデーション
     *
     * @param $mode integer
     * @return $this
     */
    public function validateTagsUsers($mode)
    {
        $return = parent::validate($this->getRegisterData(), $mode);
        if (! empty($return)) {
            throw new PloExceptionArrayMessages(['不正な値が含まれています']);// 要修正
        }
        return $this;
    }

    /**
     * 登録用データセッタ
     *
     * @param $tags_data
     * @param $user_id
     * @return $this
     */
    public function setRegisterTagsUsersData($tags_data, $user_id)
    {
        $register_data['user_id'] = $user_id;
        $register_data['user_groups_id'] = $tags_data;
        $register_data['regist_user_id'] = $this->getRegisterUserData()['user_id'];
        $register_data['update_user_id'] = $this->getRegisterUserData()['user_id'];
        parent::setRegisterData($register_data);
        return $this;
    }

    /**
     * TagsUsersへの登録処理
     *
     * @return $this|bool
     */
    public function execRegisterTagsUsers()
    {
        $this->RegistData($this->getRegisterData());
        if (PloError::IsError()) {
            throw new PloExceptionArrayMessages(PloError::GetErrorMessage());
        }
        return $this;
    }

    /**
     * ユーザーグループデータの削除
     * @param $user_id
     * @return $this
     */
    public function deleteUserGroupsData($user_id)
    {
        $this->setWhere('user_id', $user_id);
        if ($this->DeleteData() === false) {
            throw new PloExceptionArrayMessages(['データの削除ミス']);
        }
        return $this;
    }

    /**
     * @param array|string $user_groups_id
     * @return array|false
     */
    public function getRows_byUserGroupsId($user_groups_id)
    {
        $this->setWhere('user_groups_id', $user_groups_id);
        $rows = $this->GetList();
        if (!$rows || empty($rows)) {
            return [];
        }
        return $rows;
    }

}