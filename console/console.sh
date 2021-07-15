#!/bin/sh

get_ipv4addrs() {
    sudo /usr/sbin/ifconfig -a                                 |
    grep inet[^6]                                     |
#    sed 's/.*inet[^6][^0-9]\([0-9.]\)[^0-9].*/\1/' 
    sed 's/.*inet[^6][^0-9]\([0-9.]\)[^0-9].*/\1/' |
    grep -v '^127\.'                                  
}

# Get the aliases and functions
if [ -f ~/.bashrc ]; then
        . ~/.bashrc
fi

## Get Option-Usb Backup
# USBMENU=`sudo psql filedefender -Atq -c "select option_usb_backup from option_mst limit 1"`

# REDUNDANT="t"
# if ! type /usr/local/sbin/drbdadm >/dev/null 2>&1; then
#     REDUNDANT="f"
# fi
# User specific environment and startup programs

PATH=$PATH:$HOME/.local/bin:$HOME/bin

export PATH

echo "select no."
# echo "1) samba/nfs　start / restart / stop"
# echo "2) setting samba"
# echo "3) setting winbind"
# echo "4) setting NFS"
echo "1) configure network (eth0)"
echo "2) congirure network (eth1)"
echo "3) set NTP servers"
echo "4) check NTP servers"
echo "5) change password"
# echo "6) set syslog transferring"
echo "6) set static route"
echo "7) check static route"
# echo "13) set monthly log backup"
echo "21) reset admin password"
# if [[ $USBMENU = "1" ]]; then
#     echo "71) show usb device"
#     echo "72) mount usb device"
#     echo "73) unmount usb device"
# fi
# if [[ $REDUNDANT = "t" ]]; then
#     echo "81) set net ads join"
# fi
echo "99) reboot"
echo "100) shutdown"
echo "0) quit"

while read -p "enter no.: " command ; do
    case $command in
        0 ) {
            exit
        };

<<COMMENT

        1 ) {
            echo "samba / nfs"
            echo "1) start"
            echo "2) restart"
            echo "3) stop"
            while read -p "select no : " status ; do
                case $status in
                    [1] ) {
                        sudo systemctl enable smb.service
                        sudo systemctl enable nmb.service
                        sudo systemctl enable winbind.service
                        sudo systemctl restart smb.service
                        sudo systemctl restart nmb.service
                        sudo systemctl restart winbind.service
                        sudo systemctl restart rpcbind
                        sudo systemctl restart nfs-server
                        sudo systemctl restart nfs-lock
                        sudo systemctl restart nfs-idmap
                        sudo systemctl enable rpcbind
                        sudo systemctl enable nfs-server
                        break;
                    };;
                    [2] ) {
                        sudo systemctl enable smb.service
                        sudo systemctl enable nmb.service
                        sudo systemctl enable winbind.service
                        sudo systemctl restart smb.service
                        sudo systemctl restart nmb.service
                        sudo systemctl restart winbind.service
                        sudo systemctl restart rpcbind
                        sudo systemctl restart nfs-server
                        sudo systemctl restart nfs-lock
                        sudo systemctl restart nfs-idmap
                        sudo systemctl enable rpcbind
                        sudo systemctl enable nfs-server
                        break;
                    };;
                    [3] ) {
                        sudo systemctl disable smb.service
                        sudo systemctl disable nmb.service
                        sudo systemctl disable winbind.service
                        sudo systemctl stop smb.service
                        sudo systemctl stop winbind.service
                        sudo systemctl stop nmb.service
#                        sudo systemctl stop rpcbind
                        sudo systemctl stop nfs-server
                        sudo systemctl stop nfs-lock
                        sudo systemctl stop nfs-idmap
                        sudo systemctl disable rpcbind
                        sudo systemctl disable nfs-server
                        break;
                    };;
                    * ) {
                        echo "ERROR select no :"
                    };;
                esac
            done
        };;
        2 ) {
            cp /etc/samba/smb.conf /home/filedefender/
            echo "setting segument"
            echo "1) inside"
            echo "2) outside"
            while read -p "select no ：" segumentationId ; do
                case $segumentationId in
                    [1] ) {
                        segumentationName="inside"
                        break;
                    };;
                    [2] ) {
                        segumentationName="outside"
                        break;
                    };;
                    * ) {
                        echo "ERROR select no :"
                    };;
                esac
            done
            sed -i -e "s/path = \/var\/www\/application\/folder\/.*/path = \/var\/www\/application\/folder\/$segumentationName\/%U\/data/g" /home/filedefender/smb.conf
            read -p "host name ：" hostName
            sed -i -e "s/netbios .*/netbios $hostName/g" /home/filedefender/smb.conf
            sudo chmod 666 /etc/samba/smb.conf
            cat /home/filedefender/smb.conf > /etc/samba/smb.conf
            sudo chmod 644 /etc/samba/smb.conf
            rm -f /home/filedefender/smb.conf
            
            tmpIpArray=$(get_ipv4addrs)
            cp /etc/hosts /home/filedefender/
            sudo chmod 666 /etc/hosts
            for ip in ${tmpIpArray}; do
                sed -i -e "s/$ip .*//g" /home/filedefender/hosts
                /usr/bin/echo $ip $hostName >> /home/filedefender/hosts
            done
            sudo /usr/bin/hostnamectl set-hostname $hostName
            sudo chmod 666 /etc/hosts
            cat /home/filedefender/hosts > /etc/hosts
            sudo chmod 644 /etc/hosts
            rm -f /home/filedefender/hosts
        };;
        3 ) {
            sudo /usr/sbin/authconfig-tui
        };;
        4 ) {
            read -p "segument of inside (ex 192.168.1.101/24)：" inside
            read -p "segument of outside (ex 192.168.1.101/24)：" outside
            inside=${inside/\//\\\/}
            outside=${outside/\//\\\/}
            cp /etc/exports /home/filedefender/
            sed -i -e "s/\/var\/www\/application\/folder\/inside .*/\/var\/www\/application\/folder\/inside $inside\(rw,all_squash\)/g" /home/filedefender/exports
            sed -i -e "s/\/var\/www\/application\/folder\/outside .*/\/var\/www\/application\/folder\/outside $outside\(rw,all_squash\)/g" /home/filedefender/exports
            sed -i -e "s/\/var\/www\/application\/folder .*/\/var\/www\/application\/folder $inside(rw,all_squash) $outside\(rw,all_squash\)/g" /home/filedefender/exports
            sudo chmod 666 /etc/exports
            cat /home/filedefender/exports > /etc/exports
            sudo chmod 644 /etc/exports
            rm -f /home/filedefender/exports
        }
        10 ) {
            read -p "transfer syslog server? (y/n)：" useSyslog
            case $useSyslog in
                [y] ) {
                    read -p "type syslog server's hostname：" syslogServerHost
                    if [ ${syslogServerHost} = "" ]; then
                    echo "ERROR select no :";
                    else
                    cp /etc/rsyslog.conf /home/filedefender/
                    #転送先/var/log/messagesの下に新転送先追記
                    syslog_output_path_row=$(grep -n "*.info;mail.none;authpriv.none;cron.none.*\/var\/log\/messages" /home/filedefender/rsyslog.conf)
                    row_num=$(echo $syslog_output_path_row | sed -e "s/^\(.*\):.*$/\1/")
                    sed -i -e "${row_num}a \*.info;mail.none;authpriv.none;cron.none       @$syslogServerHost" /home/filedefender/rsyslog.conf
                    #３個以上転送先指定があれば３つ目削除
                    syslog_output_path_num=$(grep -c "*.info;mail.none;authpriv.none;cron.none" /home/filedefender/rsyslog.conf)
                    if [ $syslog_output_path_num -gt 2 ]; then
                        delete_row_num=$((row_num + 2))
                        sed -i -e "${delete_row_num}d" /home/filedefender/rsyslog.conf
                    fi
                    #sed -i -e "s/\*.info;mail.none;authpriv.none;cron.none .*/\*.info;mail.none;authpriv.none;cron.none       @$syslogServerHost/g" /home/filedefender/rsyslog.conf
                    sed -i -e "s/#\$ActionQueueFileName fwdRule1.*/\$ActionQueueFileName fwdRule1/g" /home/filedefender/rsyslog.conf
                    sed -i -e "s/#\$ActionQueueMaxDiskSpace 1g.*/\$ActionQueueMaxDiskSpace 1g/g" /home/filedefender/rsyslog.conf
                    sed -i -e "s/#\$ActionQueueSaveOnShutdown on.*/\$ActionQueueSaveOnShutdown on/g" /home/filedefender/rsyslog.conf
                    sed -i -e "s/#\$ActionQueueType LinkedList.*/\$ActionQueueType LinkedList/g" /home/filedefender/rsyslog.conf
                    sed -i -e "s/#\$ActionResumeRetryCount -1.*/\$ActionResumeRetryCount -1/g" /home/filedefender/rsyslog.conf
                    sudo chmod 666 /etc/rsyslog.conf
                    cat /home/filedefender/rsyslog.conf > /etc/rsyslog.conf
                    sudo chmod 644 /etc/rsyslog.conf
                    rm -f /home/filedefender/rsyslog.conf
                    sudo systemctl restart rsyslog
                    echo "complete syslog setting."
                    fi
                };;
                [n] ) {
                    cp /etc/rsyslog.conf /home/filedefender/
                    #syslog転送先指定が２つある場合、２つ目を消す
                    syslog_output_path_num=$(grep -c "*.info;mail.none;authpriv.none;cron.none" /home/filedefender/rsyslog.conf)
                    if [ $syslog_output_path_num -gt 1 ]; then
                    syslog_output_path_row=$(grep -n "*.info;mail.none;authpriv.none;cron.none.*\/var\/log\/messages" /home/filedefender/rsyslog.conf)
                    row_num=$(echo $syslog_output_path_row | sed -e "s/^\(.*\):.*$/\1/")
                    delete_row_num=$((row_num + 1))
                    sed -i -e "${delete_row_num}d" /home/filedefender/rsyslog.conf
                    fi
                    #sed -i -e "s/\*.info;mail.none;authpriv.none;cron.none .*/\*.info;mail.none;authpriv.none;cron.none       \/var\/log\/messages/g" /home/filedefender/rsyslog.conf
                    sed -i -e "s/\$ActionQueueFileName fwdRule1.*/#\$ActionQueueFileName fwdRule1/g" /home/filedefender/rsyslog.conf
                    sed -i -e "s/\$ActionQueueMaxDiskSpace 1g.*/#\$ActionQueueMaxDiskSpace 1g/g" /home/filedefender/rsyslog.conf
                    sed -i -e "s/\$ActionQueueSaveOnShutdown on.*/#\$ActionQueueSaveOnShutdown on/g" /home/filedefender/rsyslog.conf
                    sed -i -e "s/\$ActionQueueType LinkedList.*/#\$ActionQueueType LinkedList/g" /home/filedefender/rsyslog.conf
                    sed -i -e "s/\$ActionResumeRetryCount -1.*/#\$ActionResumeRetryCount -1/g" /home/filedefender/rsyslog.conf
                    sudo chmod 666 /etc/rsyslog.conf
                    cat /home/filedefender/rsyslog.conf > /etc/rsyslog.conf
                    sudo chmod 644 /etc/rsyslog.conf
                    rm -f /home/filedefender/rsyslog.conf
                    sudo systemctl restart rsyslog
                    echo "complete syslog setting."
                };;
              * ) {
                    echo "ERROR select no :"
                };;
            esac
        };;
        13 ) {
            while read -p "use backup to NAS? [y,n]" use_nas ; do
                case $use_nas in
                    [y] ) {
                        echo "1) NFS"
                        echo "2) CIFS"
                        while read -p "choose protocol :" protocol ; do
                            case $protocol in
                                1 ) {
                                    read -p "host name of NAS (ex 192.168.1.1)：" host_name
                                    read -p "path of NAS (ex /backup/filedefender/)：" host_path
                                    read -p "email address for error (ex aaaa@aaaa.co.jp)：" email
                                    host_path=`echo "${host_path}" | sed -e "s/\//\\\\\\\\\//g"`
                                    email=`echo "${email}" | sed -e "s/\//\\\\\\\\\//g"`
                                    cp /var/www/php_cnf/ini/save_log.ini /home/filedefender/
                                    sed -i -e "s/SAVE_LOG = .*/SAVE_LOG = true;/g" /home/filedefender/save_log.ini
                                    sed -i -e "s/SAVE_LOG_PROTOCOL = .*/SAVE_LOG_PROTOCOL = \"NFS\";/g" /home/filedefender/save_log.ini
                                    sed -i -e "s/SAVE_LOG_HOST = .*/SAVE_LOG_HOST = \"$host_name\";/g" /home/filedefender/save_log.ini
                                    sed -i -e "s/SAVE_LOG_REMOTE_PATH = .*/SAVE_LOG_REMOTE_PATH = \"$host_path\";/g" /home/filedefender/save_log.ini
                                    sed -i -e "s/SAVE_LOG_ERROR_MAIL_TO = .*/SAVE_LOG_ERROR_MAIL_TO = \"$email\";/g" /home/filedefender/save_log.ini
                                    sudo chmod 666 /var/www/php_cnf/ini/save_log.ini
                                    cat /home/filedefender/save_log.ini > /var/www/php_cnf/ini/save_log.ini
                                    sudo chmod 644 /var/www/php_cnf/ini/save_log.ini
                                    rm -f /home/filedefender/save_log.ini
                                    break;
                                };;
                                2 ) {
                                    read -p "host name of NAS (ex 192.168.1.1)：" host_name
                                    read -p "path of NAS (ex share)：" host_path
                                    read -p "user name of NAS ：" cifs_user_name
                                    read -p "password of NAS ：" cifs_password
                                    read -p "email address for error (ex aaaa@aaaa.co.jp)：" email
                                    host_path=`echo "${host_path}" | sed -e "s/\//\\\\\\\\\//g"`
                                    cifs_user_name=`echo "${cifs_user_name}" | sed -e "s/\//\\\\\\\\\//g"`
                                    cifs_password=`echo "${cifs_password}" | sed -e "s/\//\\\\\\\\\//g"`
                                    email=`echo "${email}" | sed -e "s/\//\\\\\\\\\//g"`
                                    cp /var/www/php_cnf/ini/save_log.ini /home/filedefender/
                                    sed -i -e "s/SAVE_LOG = .*/SAVE_LOG = true;/g" /home/filedefender/save_log.ini
                                    sed -i -e "s/SAVE_LOG_PROTOCOL = .*/SAVE_LOG_PROTOCOL = \"CIFS\";/g" /home/filedefender/save_log.ini
                                    sed -i -e "s/SAVE_LOG_HOST = .*/SAVE_LOG_HOST = \"$host_name\";/g" /home/filedefender/save_log.ini
                                    sed -i -e "s/SAVE_LOG_REMOTE_PATH = .*/SAVE_LOG_REMOTE_PATH = \"$host_path\";/g" /home/filedefender/save_log.ini
                                    sed -i -e "s/SAVE_LOG_CIFS_USER_NAME = .*/SAVE_LOG_CIFS_USER_NAME = \"$cifs_user_name\";/g" /home/filedefender/save_log.ini
                                    sed -i -e "s/SAVE_LOG_CIFS_PASSWORD = .*/SAVE_LOG_CIFS_PASSWORD = \"$cifs_password\";/g" /home/filedefender/save_log.ini
                                    sed -i -e "s/SAVE_LOG_ERROR_MAIL_TO = .*/SAVE_LOG_ERROR_MAIL_TO = \"$email\";/g" /home/filedefender/save_log.ini
                                    sudo chmod 666 /var/www/php_cnf/ini/save_log.ini
                                    cat /home/filedefender/save_log.ini > /var/www/php_cnf/ini/save_log.ini
                                    sudo chmod 644 /var/www/php_cnf/ini/save_log.ini
                                    rm -f /home/filedefender/save_log.ini
                                    break;
                                };;
                                * ) {
                                    echo "ERROR choose protocol :"
                                };;
                            esac
                        done
                        break;
                    };;
                    [n] ) {
                        cp /var/www/php_cnf/ini/save_log.ini /home/filedefender/
                        sed -i -e "s/SAVE_LOG = .*/SAVE_LOG = false;/g" /home/filedefender/save_log.ini
                        sudo chmod 666 /var/www/php_cnf/ini/save_log.ini
                        cat /home/filedefender/save_log.ini > /var/www/php_cnf/ini/save_log.ini
                        sudo chmod 644 /var/www/php_cnf/ini/save_log.ini
                        rm -f /home/filedefender/save_log.ini
                        break ;
                    };;
                    * ) {
                        echo "ERROR select no :"
                    };;
                esac
            done
            echo "complete NAS setting."
        };;
        71 ) {
            if [[ $USBMENU != "1" ]]; then
                echo "ERROR select no :"
                continue
            fi
            ls -1 /dev/sd* > /data/mount/now_device
            comm -13 --nocheck-order /data/mount/default_device /data/mount/now_device
            rm -f /data/mount/now_device
        };;
        72 ) {
            if [[ $USBMENU != "1" ]]; then
                echo "ERROR select no :"
                continue
            fi
            read -rp "use device name?:" usb_name
            sudo /usr/bin/mount $usb_name /data/mount/usb
            echo "mount usb device"
        };;
        73 ) {
            if [[ $USBMENU != "1" ]]; then
                echo "ERROR select no :"
                continue
            fi
            sudo /usr/bin/umount /data/mount/usb
            echo "unmount usb device"
        };;
        81 ) {
            if [[ $REDUNDANT = "f" ]]; then
                echo "ERROR select no :"
                continue
            fi
            read -rp "use net ADS join? [y,n]:" use_ads
                case $use_ads in
                    [y] ) {
                        read -rp "user name of Active Directory :" ad_user
                        if [[ "${ad_user}" = "" ]]; then
                            echo "ERROR user name:"
                            continue
                        fi

                        read -srp "password of Active Directory :" ad_password
                        echo ""
                        if [[ "${ad_password}" = "" ]]; then
                            echo "ERROR password:"
                            continue
                        fi

                        sudo chmod 666 /var/www/application/configs/net_ads_pass.ini
                        echo `date` | sudo /usr/bin/openssl sha1 |  sed "s#(stdin)= ##g" > /var/www/application/configs/net_ads_pass.ini
                        aes_pass=`echo "${ad_password}" | sudo /usr/bin/openssl enc -aes-256-cbc -e -base64 -pass file:/var/www/application/configs/net_ads_pass.ini`
                        sudo chmod 644 /var/www/application/configs/net_ads_pass.ini

                        sudo chmod 666 /var/www/application/configs/net_ads.ini
                        echo "[production]" > /var/www/application/configs/net_ads.ini
                        echo "ad.user = '${ad_user}'" >> /var/www/application/configs/net_ads.ini
                        echo "ad.pass = '${aes_pass}'" >> /var/www/application/configs/net_ads.ini
                        echo "ad.flag = t" >> /var/www/application/configs/net_ads.ini
                        sudo chmod 644 /var/www/application/configs/net_ads.ini
                    };;
                    [n] ) {
                        sudo chmod 666 /var/www/application/configs/net_ads.ini
                        echo "[production]" > /var/www/application/configs/net_ads.ini
                        echo "ad.user = ''" >> /var/www/application/configs/net_ads.ini
                        echo "ad.pass = ''" >> /var/www/application/configs/net_ads.ini
                        echo "ad.flag = f" >> /var/www/application/configs/net_ads.ini
                        sudo chmod 644 /var/www/application/configs/net_ads.ini
                    };;
                    * ) {
                        echo "ERROR select no :"
                    };;
                esac
        };;

COMMENT
        ;;
        1 ) {
            eth="eth0"
            read -rp "ip address (ex 192.168.1.101/24)：" ip
            if [[ ! "${ip}" =~ ^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\/([8-9]|1[0-9]|2[0-9]|3[0-2])$ ]]; then
            echo "ERROR ip address :"
            continue
            fi
            read -rp "gateway address (ex 192.168.1.1)：" gateway
            if [[ ! "${gateway}" =~ ^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$ ]]; then
            echo "ERROR gateway address :"
            continue
            fi
            read -rp "DNS1(ex 192.168.3.1)：" dns1
            if [[ ! "${dns1}" =~ ^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$ ]]; then
            echo "ERROR DNS1 :"
            continue
            fi
            read -rp "DNS2(ex 192.168.3.2)：" dns2
            if [[ ! "${dns2}" =~ ^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$ && -n "$dns2" ]]; then
            echo "ERROR DNS2 :"
            continue
            fi
            if [[ -n "$dns2" ]]; then
                sudo /usr/bin/nmcli connection modify $eth ipv4.addresses $ip ipv4.gateway $gateway ipv4.dns $dns1 +ipv4.dns $dns2 2>&1
            else
                sudo /usr/bin/nmcli connection modify $eth ipv4.addresses $ip ipv4.gateway $gateway ipv4.dns $dns1 2>&1
            fi
            sudo nmcli c down $eth;sudo nmcli c up $eth
        };;
        2 ) {
            eth="eth1"
            start="0";
            while read -p "use eth1? [y,n]" segumentationId ; do
                case $segumentationId in
                    [y] ) {
                        start="1";
                        break;
                    };;
                    [n] ) {
                        sudo nmcli c down $eth;
                        sudo nmcli c m $eth connection.autoconnect no
                        echo "stopped $eth."
                        break ;
                    };;
                    * ) {
                        echo "ERROR select no :"
                    };;
                esac
            done
            if [ ${start} = "1" ]; then
                read -rp "ip address (ex 192.168.1.101/24)：" ip
            if [[ ! "${ip}" =~ ^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\/([8-9]|1[0-9]|2[0-9]|3[0-2])$ ]]; then
            echo "ERROR ip address :"
            continue
            fi
                read -rp "gateway address (ex 192.168.1.1)：" gateway
            if [[ ! "${gateway}" =~ ^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$ ]]; then
            echo "ERROR gateway address :"
            continue
            fi
                read -rp "DNS1(ex 192.168.3.1)：" dns1
            if [[ ! "${dns1}" =~ ^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$ ]]; then
            echo "ERROR DNS1 :"
            continue
            fi
                read -rp "DNS2(ex 192.168.3.2)：" dns2
            if [[ ! "${dns2}" =~ ^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$ && -n "$dns2" ]]; then
            echo "ERROR DNS2 :"
            continue
            fi
            if [[ -n "$dns2" ]]; then
                sudo /usr/bin/nmcli connection modify $eth ipv4.addresses $ip ipv4.gateway $gateway ipv4.dns $dns1 +ipv4.dns $dns2 2>&1
            else
                sudo /usr/bin/nmcli connection modify $eth ipv4.addresses $ip ipv4.gateway $gateway ipv4.dns $dns1 2>&1
            fi
                sudo nmcli c down $eth;sudo nmcli c up $eth
                sudo nmcli c m $eth connection.autoconnect yes
            fi
        };;
        3 ) {
            read -rp "ntp server (ex 192.168.1.1 192.168.1.2):" ntpIp
            if [[ "${ntpIp}" = "" ]]; then
                echo "ERROR ntp server："
                continue
            fi
            ntpList=""
            i=1
            unset array[@] 
            for var in ${ntpIp[@]}; do
                if [[ "$var" =~ \\ || ! "${var}" =~ ^[-_\\.a-zA-Z0-9]+$ ]]; then
                    echo "ERROR ntp server："
                    continue 2
                fi
                for list in ${array[@]}; do
                    if [[ "${list}" = "${var}" ]]; then
                        continue 2
                    fi
                done
                if [[  $i > "1" ]]; then
                    ntpList=$ntpList"\n"
                fi
                ntpList=$ntpList"server ${var}"
                i=`expr $i + 1`
                array=("${array[@]}" "${var}")
            done
            cp /etc/ntp.conf /home/filedefender/
            grep -E "^server.*" /home/filedefender/ntp.conf > /home/filedefender/tmp_ntplist1.txt
            chmod 666 /home/filedefender/tmp_ntplist1.txt
            tail -n +2 /home/filedefender/tmp_ntplist1.txt > /home/filedefender/tmp_ntplist2.txt
            chmod 666 /home/filedefender/tmp_ntplist2.txt
            cat /home/filedefender/tmp_ntplist2.txt | while read line
            do
                sed -i -e "/${line}/d" /home/filedefender/ntp.conf
            done 
            sed -i -e "s/^server .*/$ntpList/g" /home/filedefender/ntp.conf
            sudo chmod 666 /etc/ntp.conf
            cat /home/filedefender/ntp.conf > /etc/ntp.conf
            sudo chmod 644 /etc/ntp.conf
            rm -f /home/filedefender/ntp.conf
            rm -f /home/filedefender/tmp_ntplist*.txt
            sudo systemctl restart ntpd
        };;
        4 ) {
            /usr/sbin/ntpq -p 2>&1 | sed "s#/usr/sbin/ntpq: read: Connection refused#NTP not running.#g"
        };;
        5 ) {
            passwd
        };;
        6 ) {
            sudo /sbin/ifconfig eth1 | grep inet > /dev/null
            status=$?
            sudo /usr/bin/nmtui
            sudo nmcli c down eth0;sudo nmcli c up eth0
            if [ ${status} = "1" ]; then
                echo "eth1 is not active."
#                sudo nmcli c down eth1;
            else
                echo "eth1 is restarted."
                sudo nmcli c down eth1;sudo nmcli c up eth1
            fi
#echo "########################"
#echo "change"
#echo $status
#echo "########################"
        };;
        7 ) {
            sudo /usr/sbin/ip route
        };;
        21 ) {
            read -p "reset admin password? (y/n) :" useReset
            case $useReset in
                [y] ) {
                    sudo psql -c "update user_mst set password = '8d9548f95b0a4e77a1bb8cb047da8045c76a75047613edf48f52487d08ade5eb' where user_id = '000001';" filedefender -U postgres > /dev/null 2>&1
                    echo "admin password reset."
                };;
                [n] ) {
                    echo "canceled."
                };;
              * ) {
                    echo "ERROR select no :"
                };;
            esac
        };;
        99 ) {
            read -p "reboot File Defender? (y/n) :" useReboot
            case $useReboot in
                [y] ) {
                    echo "reboot."
                    sudo /usr/sbin/reboot
                };;
                [n] ) {
                    echo "canceled."
                };;
              * ) {
                    echo "ERROR select no :"
                };;
            esac
        };;
        100 ) {
            read -p "shutdown File Defender? (y/n) :" useShutdown
            case $useShutdown in
                [y] ) {
                    echo "shutdown."
                    sudo /usr/sbin/shutdown -h now
                };;
                [n] ) {
                    echo "canceled."
                };;
              * ) {
                    echo "ERROR select no :"
                };;
            esac
        };;
        * ) {
            echo "ERROR select no :"
        };;
    esac
done



