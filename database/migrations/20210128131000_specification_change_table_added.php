<?php
use Phinx\Migration\AbstractMigration;

class SpecificationChangeTableAdded extends AbstractMigration
{
    public function up()
    {
        $this->execute("
CREATE TABLE applications_extensions
(
    application_control_id char(5) NOT NULL
     CONSTRAINT applications_extensions_application_control_id_fkey
     REFERENCES application_control_mst on delete cascade,
    extension varchar(255) NULL,
    regist_user_id char(6) NOT NULL,
    update_user_id char(6) NOT NULL,
    regist_date timestamp NOT NULL DEFAULT NOW(),
    update_date timestamp NOT NULL DEFAULT NOW(),
    CONSTRAINT applications_extensions_pkey
    primary key (application_control_id, extension)
);
ALTER TABLE applications_extensions OWNER TO postgres;
ALTER TABLE public.application_control_mst DROP file_extension;
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00002','doc','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00002','docm','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00002','docx','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00002','dot','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00002','dotm','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00002','dotx','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00002','htm','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00002','html','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00002','mht','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00002','mhtml','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00002','odt','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00002','pdf','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00002','rtf','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00002','txt','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00002','wps','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00002','xml','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00002','xps','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','bmp','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','emf','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','gif','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','jpg','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','mp4','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','odp','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','pdf','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','png','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','pot','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','potm','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','potx','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','ppa','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','ppam','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','pps','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','ppsm','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','ppsx','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','ppt','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','pptm','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','pptx','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','rtf','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','thmx','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','tif','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','wmf','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','wmv','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','xml','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00003','xps','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','csv','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','dbf','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','dif','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','htm','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','html','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','mht','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','mhtml','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','ods','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','pdf','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','prn','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','slk','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','txt','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','xla','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','xlam','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','xls','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','xlsb','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','xlsm','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','xlsx','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','xlt','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','xltm','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','xltx','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','xlw','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','xml','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00004','xps','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00005','bmp','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00005','dib','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00005','jpg','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00005','jpeg','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00005','jpe','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00005','jfif','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00005','gif','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00005','tiff','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00005','tif','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00005','png','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00005','heic','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00006','txt','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00007','rtf','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00007','docx','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00007','odt','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00007','txt','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00009','dxf','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00009','dwt','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00009','dwf','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00009','dwfx','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00009','pdf','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00009','dgn','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00009','fbx','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00009','wmf','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00009','sat','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00009','stl','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00009','eps','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00009','dxx','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00009','bmp','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00009','dwg','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00009','jges','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00009','jgs','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00010','jww','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00010','jwc','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00010','dxf','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00010','sfc','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00010','p21','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00011','doc','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00011','docx','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00011','xlsx','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00011','pptx','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00011','rtf','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00011','jpg','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00011','tiff','000001','000001',NOW(),NOW());
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date) VALUES ('00011','png','000001','000001',NOW(),NOW());
");
    }

    public function down()
    {
        $this->execute("
DROP TABLE IF EXISTS applications_extensions CASCADE;
ALTER TABLE public.application_control_mst ADD file_extension varchar(255) NULL;
");
    }
}
