<?php

class LdapUserGroups extends LdapUserGroups_api
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
     * @param $ldap_id
     * @return $this
     */
    public function setRegisterTagsUsersData($tags_data, $ldap_id)
    {
        $register_data['ldap_id'] = $ldap_id;
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
     * LDAP ユーザーグループデータの削除
     * @param $ldap_id
     * @return $this
     */
    public function deleteUserGroupsData($ldap_id)
    {
        $this->setWhere('ldap_id', $ldap_id);
        if ($this->DeleteData() === false) {
            throw new PloExceptionArrayMessages(['データの削除ミス']);
        }
        return $this;
    }

    /**
     * @param $ldap_id
     * @return array
     */
    public function getUserGroupsId_byLdapId($ldap_id)
    {
        // LDAP ユーザーグループ リスト取得
        $this->resetWhere();
        $this->setWhere('ldap_id', $ldap_id);
        $list_ldapUserGroups = $this->GetList();
        if (!$list_ldapUserGroups) {
            return [];
        }
        $user_groups_ids_byLdapUserGroups = array_column($list_ldapUserGroups, 'user_groups_id');
        return $user_groups_ids_byLdapUserGroups;
    }

    /**
     * @param $ldap_id
     * @param string $alias
     * @return array|false
     */
    public function getRows_byLdapId($ldap_id, $alias='')
    {
        $this->resetWhere();
        if (!empty($alias)) {
            $this->setWhere('ldap_id', $ldap_id, $alias);
        } else {
            $this->setWhere('ldap_id', $ldap_id);
        }
        $rows = $this->getList();
        if (!$rows || empty($rows)) {
            return [];
        }
        return $rows;
    }
}