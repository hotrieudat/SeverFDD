<?php

class ProjectsFilesHash extends ProjectsFilesHash_api
{
    /**
     * @param $hash
     * @return array|bool|int
     */
    public function getRow_byHash($hash)
    {
        $this->setWhere('hash', $hash);
        $row = $this->getOne();
        if (!$row || empty($row)) {
            return [];
        }
        return $row;
    }
}