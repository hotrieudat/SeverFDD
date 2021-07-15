# syslog 受信サーバー設定手順

## rsyslog の確認

以下コマンドを実行して、バージョンが表示されなければ rsyslogのインストールを実行してください

```linux
rsyslogd -v
```

## rsyslog のインストール

```linux
yum install rsyslog -y
```

## syslog 受信サーバーの設定

### 設定ファイル編集

```linux
vi /etc/rsyslog.conf
```

### 設定ファイルの修正内容

* 以下行のコメントアウト
```linux
$ModLoad imudp
$UDPServerRun 514
```
* 末尾に以下内容を追加  
  (※IPアドレス部分はテスト用のサーバーのIPアドレスに書き換えてください)
```linux
*.* @192.168.12.30:514
```


### rsyslog の設定の反映＋再起動

```linux
systemctl enable rsyslog.service
systemctl restart rsyslog.service
```

## apache の設定変更

### 設定ファイルの編集

```linux
vi /etc/httpd/conf/httpd.conf
```

### 設定ファイルの修正内容

* CustomLogの書き換え
```linux
CustomLog "| /bin/sh -c '/usr/bin/tee -a /var/log/httpd/httpd-access.log | /usr/bin/logger -thttpd -plocal1.notice'" combined
```

### appache 再起動

```linux
systemctl restart httpd.service
```
