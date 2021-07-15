<?php
use Phinx\Migration\AbstractMigration;

class ModifyAndUpdateTableApplicationControlMst extends AbstractMigration
{
//    -- set default and notnull on update_date.
//    -- add column regist/update user_id
//    -- UPDATE exists record
//    -- add not null on regist/update user_id.
    public function up()
    {
        $this->execute("
ALTER TABLE public.application_control_mst ALTER COLUMN update_date SET DEFAULT now();
ALTER TABLE public.application_control_mst ALTER COLUMN update_date SET NOT NULL;
ALTER TABLE public.application_control_mst ADD update_user_id char(6);
ALTER TABLE public.application_control_mst ADD regist_user_id char(6);
UPDATE public.application_control_mst SET regist_user_id = '000001', update_user_id = '000001';
ALTER TABLE public.application_control_mst ALTER COLUMN regist_user_id SET NOT NULL;
ALTER TABLE public.application_control_mst ALTER COLUMN update_user_id SET NOT NULL;
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_APPLICATION_CONTROL_001', 0, '拡張子が空になっています。', '拡張子が空になっています。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_APPLICATION_CONTROL_001', 0, 'Extension name is required.', 'Extension name is required.', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_APPLICATION_CONTROL_002', 0, '拡張子名に｢/:!*|\"<>?｣は使用できません。', '拡張子名に｢/:!*|\"<>?｣は使用できません。。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_APPLICATION_CONTROL_002', 0, 'Invalid characters in the extension name.', 'Invalid characters in the extension name.', 'NULL');
");
    }

    public function down()
    {
//        -- remove column regist/update user_id
//        -- remove default and notnull on update_date.
        $this->execute("
DELETE FROM public.word_mst WHERE language_id LIKE '02' ESCAPE '#' AND word_id LIKE 'E_WHITE_LIST_001' ESCAPE '#';
DELETE FROM public.word_mst WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'E_WHITE_LIST_002' ESCAPE '#';
DELETE FROM public.word_mst WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'E_WHITE_LIST_001' ESCAPE '#';
DELETE FROM public.word_mst WHERE language_id LIKE '02' ESCAPE '#' AND word_id LIKE 'E_WHITE_LIST_002' ESCAPE '#';
ALTER TABLE public.application_control_mst DROP update_user_id;
ALTER TABLE public.application_control_mst DROP regist_user_id;
-- remove default and notnull on update_date.
ALTER TABLE public.application_control_mst ALTER COLUMN update_date DROP DEFAULT;
ALTER TABLE public.application_control_mst ALTER COLUMN update_date DROP NOT NULL;
");
    }
}
