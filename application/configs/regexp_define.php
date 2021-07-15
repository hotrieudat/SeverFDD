<?php
define('REGEXP_LOGIN_CODE', '/^[a-zA-Z0-9_.\-@]*$/');
define('REGEXP_URL_HASH', '/^[a-f0-9]{64}$/');
define('REGEXP_IP_ADDRESS', '/\A(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\z/');
define('REGEXP_MAIL_ADDRESS', '/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/');
define('REGEXP_HANKAKU_SU', '/\A[0-9]+\z/');
define('REGEXP_HANKAKU_EISU', '/^[\w]+$/');
define('REGEXP_IS_EXISTS_HALF_WIDTH_ALNUM_CHAR_All', '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/');
define('REGEXP_BIND_VALUE_MAIL', '/^\[MAIL\]+$/');
define('REGEXP_HALF_CHAR_ALNUM_PLUS_UNDERBAR_MINUS', '/\A[0-9a-zA-Z\+_-].+\z/');
define('REGEXP_LIKE_DOMAIN', '/\A[0-9]*\.[0-9]*\.[0-9]*\.[0-9]*\z/');
define('REGEXP_SYSLOG', "/\nlocal0.info.*[^\n]*|\n#local0.info.*[^\n]*/");
define('REGEXP_EXTENSION', '/[\¥\/\:\*\?\"\<\>|]+/');