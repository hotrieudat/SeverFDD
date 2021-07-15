<?php

class PloService_ReissuePassword_Strategy_Local implements PloService_ReissuePassword_Strategy_Interface
{

    public function getMailSubject($url, $company, $hash)
    {
        $url = $this->generateUrl($url, $company, $hash);
        return str_replace("[URL]", $url, PloService_EditableWord::getMessage('##PASSWORD_REISSUE_MAIL_TITLE##'));
    }

    public function getMailBody($url, $company, $hash)
    {
        $url = $this->generateUrl($url, $company, $hash);
        return str_replace("[URL]", $url, PloService_EditableWord::getMessage('##PASSWORD_REISSUE_MAIL_BODY##'));
    }

    public function getMailFrom()
    {
        return PloService_EditableWord::getMessage("##PASSWORD_REISSUE_MAIL_FROM##") === '[MAIL]'
                ? PloService_EditableWord::getMessage("##DEFAULT_FROM##")
                : PloService_EditableWord::getMessage("##PASSWORD_REISSUE_MAIL_FROM##");
    }

    public function registerOnetimePassword($user_record, $hash)
    {
        User::saveUserOnetimePass($user_record["user_id"], $hash);
    }

    private function generateUrl($url, $company, $hash)
    {
        return "{$url}/reissue-password/access/{$hash}";
    }

}
