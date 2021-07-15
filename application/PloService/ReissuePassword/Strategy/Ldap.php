<?php

class PloService_ReissuePassword_Strategy_Ldap implements PloService_ReissuePassword_Strategy_Interface
{

    public function getMailSubject($url, $company, $hash)
    {
        $url = $this->generateUrl($url, $company);
        return str_replace("[URL]", $url, PloService_EditableWord::getMessage('##PASSWORD_REISSUE_LDAP_ERROR_MAIL_TITLE##'));
    }

    public function getMailBody($url, $company, $hash)
    {
        $url = $this->generateUrl($url, $company);
        return str_replace("[URL]", $url, PloService_EditableWord::getMessage('##PASSWORD_REISSUE_LDAP_ERROR_MAIL_BODY##'));
    }

    public function getMailFrom()
    {
        return PloService_EditableWord::getMessage("##PASSWORD_REISSUE_LDAP_ERROR_MAIL_FROM##") === '[MAIL]'
                ? PloService_EditableWord::getMessage("##DEFAULT_FROM##")
                : PloService_EditableWord::getMessage("##PASSWORD_REISSUE_LDAP_ERROR_MAIL_FROM##");
    }

    /**
     * LDAPの場合登録を行わない
     */
    public function registerOnetimePassword($user_record, $hash)
    {
        return null;
    }

    private function generateUrl($url, $company)
    {
        return "{$url}/index";
    }
}
