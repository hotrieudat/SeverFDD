# Server
#################################################################################
# Create directory and add permission, for english logo.
# If exists directory then do not create directory.
if [ ! -e /var/www/public_html/common/image/logo/logo2 ]; then
  mkdir /var/www/public_html/common/image/logo/logo2
fi
chmod 0755 /var/www/public_html/common/image/logo/logo2
chgrp apache /var/www/public_html/common/image/logo/logo2
chown apache /var/www/public_html/common/image/logo/logo2
