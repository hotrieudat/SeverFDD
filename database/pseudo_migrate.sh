#!/bin/sh
cd /var/www/database/set_up_sql
dropdb -e -U "postgres" filedefender
createdb -e -U "postgres" filedefender
psql -e -U "postgres" -d filedefender < plott_framework_create.sql
psql -e -U "postgres" -d filedefender < create.sql
psql -e -U "postgres" -d filedefender < create_view.sql
psql -e -U "postgres" -d filedefender < word_mst.sql
psql -e -U "postgres" -d filedefender < insert_data.sql
cd /var/www/database/Update
for f in `ls -1 | sort -t. -k1,1n -k2,2n -k3,3n`;
do
psql -e -U "postgres" -d filedefender < $f
done
