FROM postgres:9.3-alpine
COPY set_up_sql/plott_framework_create.sql /docker-entrypoint-initdb.d/1.sql
COPY set_up_sql/create.sql /docker-entrypoint-initdb.d/2.sql
COPY set_up_sql/create_view.sql /docker-entrypoint-initdb.d/3.sql
COPY set_up_sql/word_mst.sql /docker-entrypoint-initdb.d/4.sql
COPY set_up_sql/insert_data.sql /docker-entrypoint-initdb.d/5.sql

RUN mkdir /updates
COPY Update/*.sql /updates/
WORKDIR /updates/
RUN cat `ls -1 | sort -t. -k1,1n -k2,2n -k3,3n` > /docker-entrypoint-initdb.d/7.sql
# 1289 for Swagger-ui
COPY set_up_sql/sql_for_openapi.sql /docker-entrypoint-initdb.d/8.sql

WORKDIR /
RUN chmod 444 /docker-entrypoint-initdb.d/*.sql

