#!/bin/sh
set -ue
chown -R www-data /var/www/
mkdir -p /var/www/application/log/db
mkdir -p /var/www/application/log/debug
mkdir -p /var/www/application/log/application
mkdir -p /var/www/application/smarty/templates_c
chmod -R 775 /var/www/application/log/
chmod -R 775 /var/www/application/log/application
chmod -R 775 /var/www/application/log/debug
chmod -R 775 /var/www/application/log/db
chmod -R 775 /var/www/public_html/common/image/logo/header
chmod -R 775 /var/www/public_html/common/image/logo/logo1
chmod -R 775 /var/www/public_html/common/image/logo/logo2
chmod -R 775 /var/www/public_html/common/image/logo/tmp
chmod -R 775 /var/www/application/smarty/templates_c
sed -i 's/pg_escape_string/addslashes/g' /var/www/application/lib/PloDb.php
sed -i 's/pg_escape_string/addslashes/g' /var/www/application/ext_lib/ExtController.php
sed -i 's/pg_escape_string/addslashes/g' /var/www/application/controllers/ClientApiController.php
sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/AggregationStatuses.php
sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/ApplicationControl.php
sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/DualGroups.php
sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/DualGroupsAndGroupsUsers.php
sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/DualGroupsAndGroupsUsersForClient.php
sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/ProjectsFiles.php
sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/ProjectsFilesUsers.php
sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/ProjectsUserGroups.php
sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/User.php
sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/UserGroupsUsers.php
sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/UserLicenseRec.php
sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/UserLicenseRecWithParentCode.php
sed -i 's/pg_escape_string/addslashes/g' /var/www/application/PloService/File/UsersProjectsFiles.php
apache2-foreground
