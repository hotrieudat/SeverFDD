FROM php:5-apache

RUN apt update
RUN apt install -y git vim libpq-dev subversion

# install composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

# pgsql
RUN docker-php-ext-install pdo pdo_pgsql

RUN sed -i 's/#ServerName www.example.com:80/ServerName www.example.co.jp:80/g' /etc/apache2/apache2.conf
RUN sed -i 's/Options Indexes FollowSymLinks/Options FollowSymLinks ExecCGI/g' /etc/apache2/apache2.conf
RUN sed -i 's/DirectoryIndex index.html/DirectoryIndex index.php index.html index.cgi index.htm/g' /etc/apache2/apache2.conf
RUN sed -i 's/AddDefaultCharset UTF-8/AddDefaultCharset Off/g' /etc/apache2/apache2.conf
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf
RUN sed -i 's;DocumentRoot /var/www/html;DocumentRoot /var\/www\/public_html;g' /etc/apache2/sites-enabled/000-default.conf
RUN a2enmod rewrite


# install dependencies via composer
WORKDIR /var/www/
COPY ./composer.lock /var/www/
COPY ./composer.json /var/www/
RUN composer install --dev

# copy the other source files
COPY ./application/ /var/www/application
COPY ./library/ /var/www/library
COPY ./public_html/ /var/www/public_html
COPY ./tests/ /var/www/tests
COPY ./php.ini /usr/local/etc/php/
COPY ./phpunit.xml /var/www/
COPY ./docker_entry.sh /

# change permission
RUN chmod 444 /var/www/public_html/.htaccess
RUN chmod 775 /var/www/public_html

# ensure that web server connects to a docker db container as a db server
# @NOTE web:php5.4 / virtual server:php5.6
# Replace from pg_escape_string toaddslashes, because pg_escape_string is not in virtual server's package.
RUN sed -i 's/pg_escape_string/addslashes/g' /var/www/application/lib/PloDb.php
RUN sed -i 's/pg_escape_string/addslashes/g' /var/www/application/ext_lib/ExtController.php
RUN sed -i 's/pg_escape_string/addslashes/g' /var/www/application/controllers/ClientApiController.php
RUN sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/AggregationStatuses.php
RUN sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/ApplicationControl.php
RUN sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/DualGroups.php
RUN sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/DualGroupsAndGroupsUsers.php
RUN sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/DualGroupsAndGroupsUsersForClient.php
RUN sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/ProjectsFiles.php
RUN sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/ProjectsFilesUsers.php
RUN sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/ProjectsUserGroups.php
RUN sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/User.php
RUN sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/UserGroupsUsers.php
RUN sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/UserLicenseRec.php
RUN sed -i 's/pg_escape_string/addslashes/g' /var/www/application/models/UserLicenseRecWithParentCode.php
RUN sed -i 's/pg_escape_string/addslashes/g' /var/www/application/PloService/File/UsersProjectsFiles.php

WORKDIR /
CMD bash /docker_entry.sh
