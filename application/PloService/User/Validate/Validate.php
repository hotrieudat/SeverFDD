<?php


class PloService_User_Validate
{
    public function validate($data, $mode = 0) {
        $option = PloService_OptionContainer::getInstance();
        (new User())->setOneValidate($data["user_id"], $data, 0, $mode);
        // password 用の設定
        $error = [];
        if ($data["password"]) {
            if ($option->password_min_length < $this->register_data["password"]) {
                $error[] = array(
                    "id" => "R_COMMON_027",
                    "field" => "password",
                    "name" => "##FIELD_NAME_PASSWORD##",
                );
            }
        }
    }
}