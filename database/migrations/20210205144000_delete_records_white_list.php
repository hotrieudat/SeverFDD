<?php
use Phinx\Migration\AbstractMigration;

class DeleteRecordsWhiteList extends AbstractMigration
{
    public function up()
    {
        $this->execute("
DELETE FROM white_list;
");
    }

    public function down()
    {
        $this->execute("
DELETE FROM white_list
WHERE application_control_id = (SElECT application_control_id
                                FROM application_control_mst
                                WHERE application_original_filename = 'AcroRd32.exe')
AND exists (SELECT application_control_id FROM white_list WHERE application_control_id = (SElECT application_control_id
                                FROM application_control_mst
                                WHERE application_original_filename = 'AcroRd32.exe'));

DELETE FROM application_control_mst
WHERE application_control_id = (SElECT application_control_id
                                FROM application_control_mst
                                WHERE application_original_filename = 'AcroRd32.exe')
AND exists (SELECT application_control_id FROM application_control_mst WHERE application_control_id = (SElECT application_control_id
                                FROM application_control_mst
                                WHERE application_original_filename = 'AcroRd32.exe'));


INSERT INTO application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date, regist_user_id, update_user_id)
VALUES
       ((SELECT lpad((count(*) + 1) :: text, 5, '0')
         FROM application_control_mst), 'AcroRd32.exe', NULL, 'アドビ アクロバット リーダー DC', 'Adobe Acrobat Reader DC ', 'Adobe Acrobat Reader DC',
        1, 1, '', now(), now(), '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.dat', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), 'version.js', NULL,
        NULL, 0,
        '000001', '000001');


INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), 'desktop.ini', NULL,
        NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.JPN', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.lst', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.api', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.mui', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.sav', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, NULL,
        '\Users\*\AppData\Local\Adobe\Acrobat\DC\Cache', 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, NULL,
        '\Users\*\AppData\Local\Adobe\Acrobat\DC', 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.Manifest', NULL,
        0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.nls', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.sdb', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.clb', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.aapp', NULL, 0,
        '000001', '000001');


INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.camp', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.icm', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.gmmp', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.cdmp', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.icc', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.db', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.tmp',
        '\Users\*\AppData\Local\Temp\acrord32_sbx', 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, NULL,
        '\Users\*\AppData\Roaming\Adobe\Acrobat', 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), 'variant.js', NULL,
        NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.cdf-ms', NULL,
        0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), 'Info.plist', NULL,
        NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), 'Products.txt', NULL,
        NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), 'UxTheme.dll.Config',
        NULL, NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.lnk', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.tlb', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.ico', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.DIC', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.FON', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.pld', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.TTF', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.library-ms',
        NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.grm', NULL, 0,
        '000001', '000001');


INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.config', NULL,
        0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.ime', NULL, 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.js',
        '\Users\*\AppData\Roaming\Adobe\Acrobat\Privileged\DC\JavaScripts', 0,
        '000001', '000001');


INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.TTF', NULL, 0,
        '000001', '000001');


INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.bin',
        '\Program Files*\Adobe\Acrobat Reader DC\Reader\JavaScripts', 0,
        '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES ((SElECT application_control_id
         FROM application_control_mst
         WHERE application_original_filename = 'AcroRd32.exe'), (SELECT lpad((count(*) + 1) :: text, 4, '0')
                                                                 FROM white_list
                                                                 WHERE application_control_id =
                                                                       (SElECT application_control_id
                                                                        FROM application_control_mst
                                                                        WHERE application_original_filename =
                                                                              'AcroRd32.exe')), NULL, '.FON', NULL, 0,
        '000001', '000001');
");
    }
}
