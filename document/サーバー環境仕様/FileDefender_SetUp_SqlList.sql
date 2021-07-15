
DROP TABLE IF EXISTS application_control_mst CASCADE ;
DROP TABLE IF EXISTS application_size_mst    CASCADE ;
DROP TABLE IF EXISTS editable_word_mst       CASCADE ;
DROP TABLE IF EXISTS file_mst                CASCADE ;
DROP TABLE IF EXISTS group_mst               CASCADE ;
DROP TABLE IF EXISTS hash_mst                CASCADE ;
DROP TABLE IF EXISTS ip_whitelist_mst        CASCADE ;
DROP TABLE IF EXISTS language_mst            CASCADE ;
DROP TABLE IF EXISTS ldap_mst                CASCADE ;
DROP TABLE IF EXISTS log_rec                 CASCADE ;
DROP TABLE IF EXISTS option_mst              CASCADE ;
DROP TABLE IF EXISTS user_mst                CASCADE ;
DROP TABLE IF EXISTS view_user               CASCADE ;
DROP TABLE IF EXISTS white_list              CASCADE ;
DROP TABLE IF EXISTS word_mst                CASCADE ;



\o import.log
\i ./set_up_sql/plott_framework_create.sql
\i ./set_up_sql/create.sql
\i ./set_up_sql/create_view.sql
\i ./set_up_sql/word_mst.sql
\i ./set_up_sql/insert_data.sql
\i ./Update/1.0.5.sql
\i ./Update/1.0.6.sql
\i ./Update/1.0.7.sql
\i ./Update/1.0.8.sql
\i ./Update/1.1.0.sql
\i ./Update/1.2.0.sql
\o
