<?php
Interface PloService_ReissuePassword_Strategy_Interface
{
    public function getMailSubject($url, $company, $hash);
    public function getMailBody($url, $company, $hash);
    public function getMailFrom();
    public function registerOnetimePassword($user_record, $hash);

}
