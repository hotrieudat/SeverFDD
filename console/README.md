# コンソールユーザーの必要な設定

## 概要
* 設置関連は、/home/{ユーザー名} フォルダ下に設置すること
* 必ずしも他製品とコンソールと同じである必要はないとのこと(by矢野課長)
* 20200625時点で以下で必要なコマンドとしては以下で良いとのこと
```
1) setting network (eth0)
2) setting network (eth1)
3) setting NTP
4) check NTP
5) change password
11) setup static route
12) check static route
21) reset admin password
99) reboot
100) shutdown
0) quit
```
※多少の表現が違う場合があります

## コマンド
キックスタートに記述されています。
```
useradd -p $(perl -e 'print crypt("1111", "\$6\$saltsalt")') filedefender
mv /var/www/console/console.sh /home/filedefender/
chown filedefender.filedefender /home/filedefender/console.sh
chmod 755 /home/filedefender/console.sh
usermod -s /home/filedefender/console.sh filedefender

## set sudo for user"FileDefender"
echo '' >> /etc/sudoers
echo 'filedefender  ALL=(root) NOPASSWD:/usr/sbin/authconfig-tui' >> /etc/sudoers
echo 'filedefender  ALL=(root) NOPASSWD:/usr/sbin/ifconfig' >> /etc/sudoers
echo 'filedefender  ALL=(root) NOPASSWD:/usr/bin/vim' >> /etc/sudoers
echo 'filedefender  ALL=(root) NOPASSWD:/usr/bin/systemctl' >> /etc/sudoers
echo 'filedefender  ALL=(root) NOPASSWD:/bin/psql' >> /etc/sudoers
#echo 'filedefender  ALL=(root) NOPASSWD:/usr/bin/chmod 666 /etc/samba/smb.conf' >> /etc/sudoers
#echo 'filedefender  ALL=(root) NOPASSWD:/usr/bin/chmod 644 /etc/samba/smb.conf' >> /etc/sudoers
echo 'filedefender  ALL=(root) NOPASSWD:/usr/bin/chmod 666 /etc/hosts' >> /etc/sudoers
echo 'filedefender  ALL=(root) NOPASSWD:/usr/bin/chmod 644 /etc/hosts' >> /etc/sudoers
echo 'filedefender  ALL=(root) NOPASSWD:/usr/bin/chmod 666 /etc/exports' >> /etc/sudoers
echo 'filedefender  ALL=(root) NOPASSWD:/usr/bin/chmod 644 /etc/exports' >> /etc/sudoers
echo 'filedefender  ALL=(root) NOPASSWD:/usr/bin/chmod 666 /etc/ntp.conf' >> /etc/sudoers
echo 'filedefender  ALL=(root) NOPASSWD:/usr/bin/chmod 644 /etc/ntp.conf' >> /etc/sudoers
echo 'filedefender  ALL=(root) NOPASSWD:/usr/bin/nmcli' >> /etc/sudoers
echo 'filedefender  ALL=(root) NOPASSWD:/usr/bin/hostnamectl set-hostname *' >> /etc/sudoers
echo 'filedefender  ALL=(root) NOPASSWD:/usr/bin/chmod 666 /etc/rsyslog.conf' >> /etc/sudoers
echo 'filedefender  ALL=(root) NOPASSWD:/usr/bin/chmod 644 /etc/rsyslog.conf' >> /etc/sudoers
echo 'filedefender  ALL=(root) NOPASSWD:/usr/bin/nmtui' >> /etc/sudoers
echo 'filedefender  ALL=(root) NOPASSWD:/usr/sbin/ip route' >> /etc/sudoers
```