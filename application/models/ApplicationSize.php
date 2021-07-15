<?php
class ApplicationSize extends ApplicationSize_API
{
    public function combineUniqueId($application_control_id, $application_size_id)
    {
        return $application_control_id . self::$config->code_splitter . $application_control_id;
    }
}