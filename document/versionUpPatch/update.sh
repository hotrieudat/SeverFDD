#---update tool security string---#
#---previous version nocheck---#

# file up
################################################################################
chmod 777 /var/www/versionup/ver1.4.5.1/program/file_backup.sh
chmod 777 /var/www/versionup/ver1.4.5.1/program/file_up.sh
chmod 777 /var/www/versionup/ver1.4.5.1/program/file_rollback.sh

/var/www/versionup/ver1.4.5.1/program/file_backup.sh
/var/www/versionup/ver1.4.5.1/program/file_up.sh


# pgsql
################################################################################

# DBを更新
su - postgres -c "psql filedefender < /var/www/versionup/ver1.4.5.1/update.sql"

# dumpファイル削除
rm -f /dev/shm/fd_dumps/option_mst.dump

# smarty
rm -f /var/www/application/smarty/templates_c/*

# cron 

# Server
#################################################################################