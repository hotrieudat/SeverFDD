<?php
use Phinx\Migration\AbstractMigration;

class DeleteInsertCommonWhitelist extends AbstractMigration
{
    public function up()
    {
        $this->execute("
DELETE FROM common_white_list;
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES ('0001', 'win.ini', NULL, '\Windows', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES ('0002', NULL, '.mui', '\Windows\*', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES ('0003', NULL, '.ttf', '\Windows\Fonts', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES ('0004', NULL, '.ttc', '\Windows\Fonts', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES ('0005', NULL, '.fon', '\Windows\Fonts', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES ('0006', NULL, '.tlb', '\Windows\System32', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES ('0007', 'license.rtf', NULL, '\Windows\System32', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES ('0008', 'WINSPOOL.DRV', NULL, '\Windows\System32', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES ('0009', NULL, '.BUD', '\Windows\System32\spool\*', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES ('0010', NULL, '.GPD', '\Windows\System32\spool\*', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES ('0011', NULL, '.ini', '\Windows\System32\spool\DRIVERS\*', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES ('0012', NULL, '.js', '\Windows\System32\DriverStore\*', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES ('0013', NULL, '.dpb', '\Windows\System32\DriverStore\*', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES ('0014', NULL, '.xml', '\Windows\System32\DriverStore\*', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES ('0015', NULL, '.ini', '\Windows\System32\DriverStore\*', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES ('0016', NULL, '.lnk', NULL, 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES ('0017', NULL, '.ODF', NULL, 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES ('0018', 'sysmain.sdb', NULL, '\Windows\AppPatch*', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES ('0019', NULL, '.mun', '\Windows\SystemResources', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES ('0020', NULL, '.mui', '\Program Files\WindowsApps\*', 0, '000001', '000001');
");
    }

    /**
     * -- database/migrations/20200722014105_version_one_one_zero.php
     * -- ????????? ???????????????????????????????????????????????????????????? (Issue/245)????????????????????????????????????????????????
     * -- 8.1 ???????????????????????????????????????????????????????????????????????????Issue/263???
     * -- ????????????????????????????????????????????? Outlook??????????????????????????????????????????????????????(Issue/261)
     * -- PDF Reader????????????????????????????????? (Issue/280)
     * -- OutLook????????????????????? ???Issue/292)
     * -- Word ??????????????????????????? tmp ????????????????????? (Issue/285)
     * -- ??????????????????????????????
     * -- Win8.1 ????????????????????????????????????????????????????????????????????????????????? (Issue/263)
     * -- 8.1 ???????????????????????????????????????
     * -- database/migrations/20200722014959_version_one_two_zero.php
     */
    public function down()
    {
        $this->execute("
DELETE FROM common_white_list;
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  ('0001',
   NULL,
   '.library-ms', '\Users\*\AppData\Roaming\Microsoft\Windows\Libraries', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  ('0002',
   NULL,
   '.db', '\Users\*\AppData\Local\Microsoft\Windows\Caches', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  ('0003',
   'Desktop.ini',
   NULL, NULL , 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  ('0004',
   'Desktop.lnk',
   NULL, NULL , 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  ('0005',
   'Downloads.lnk',
   NULL, NULL , 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  ('0006',
   NULL,
   '.db', '\Users\*\AppData\Local\Microsoft\Windows\Explorer', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  ('0007',
   'OFFICE.ODF',
   NULL , '\Program Files\Microsoft Office\root\vfs\ProgramFilesCommonX86\Microsoft Shared\OFFICE16\Cultures', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  ('0008',
   NULL,
   '.xml' , '\Users\*\AppData\Local\Microsoft\Outlook\16*', 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  ('0009',
   'mapisvc.inf',
   NULL , NULL , 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  ('0010',
   'WINSPOOL.DRV',
   NULL , NULL , 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  ('0011',
   NULL,
   '.ost' , '\Users\*\AppData\Local\Microsoft\Outlook' , 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  ('0011',
   NULL,
   '.pld' , '\Windows\IME\IMEJP\DICTS' , 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  ('0012',
   NULL,
   '.dic' , '\Users\*\AppData\Roaming\Microsoft\IME\15.0\IMEJP\UserDict' , 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  ('0013',
   NULL,
   '.wer' , '\Users\*\AppData\Local\Microsoft\Windows\WER\ReportQueue\*' , 0, '000001', '000001');
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES (getCommonWhiteListNewSequence(), NULL, '.fon' , '\Windows\FONTS\' , 0, '000001', '000001');
");
    }
}
