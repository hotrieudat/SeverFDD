<?php
use Phinx\Migration\AbstractMigration;

class T1530ModifyApplicationControl extends AbstractMigration
{
    public function up()
    {
        $this->execute("
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_FILE_EXTENSIONS','0','拡張子','拡張子');
ALTER TABLE public.application_control_mst ADD file_extension varchar(255) NULL;
");

    }

    public function down()
    {
        $this->execute("
DELETE FROM public.word_mst WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'FIELD_NAME_FILE_EXTENSIONS' ESCAPE '#';
ALTER TABLE public.application_control_mst DROP file_extension;
");
    }
}
