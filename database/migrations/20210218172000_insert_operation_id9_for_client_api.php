<?php
use Phinx\Migration\AbstractMigration;

class InsertOperationId9ForClientApi extends AbstractMigration
{
    public function up()
    {
        $this->execute("
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_LOG_REC_OPERATION_ID_9', 0, '別名保存', '別名保存', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LOG_REC_OPERATION_ID_9', 0, '別名保存', '別名保存', 'NULL');

");
    }

    public function down()
    {
        $this->execute("
DELETE FROM public.word_mst WHERE word_id = 'FIELD_DATA_LOG_REC_OPERATION_ID_9';
");
    }
}
