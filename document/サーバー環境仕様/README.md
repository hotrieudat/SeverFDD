# FileDefender_キックスタートサーバーメンテナンス手順（最新バージョンへの対応）

## 1 更新対象のソース・DBの準備

1. 最新バージョンの正式リリース後、「master」リポジトリより、「database」「program/server」ディレクトリをそれぞれ zip で圧縮し、それぞれ「database.zip」「server.zip」としておく。

※クライアントアプリのアップデートを含む場合、本手順では更新対象のexeファイルが既に「server」以下の所定のパスに含まれていることを前提としています。



## 2 キックスタートサーバーへ接続し、ソース・DBをアップロードする

1. 下記の情報でSSH、SCPでキックスタートサーバーに接続する。
2. SCPにて「database.zip」「server.zip」をキックスタートサーバーにアップロードする

### ※接続の手順

```
SCPでは「master」ユーザーでサーバー接続し、データをアップロードする。
（アップロード先は /home/master 以下となる）

SSHでは「master」ユーザーでサーバー接続後、「root」ユーザーになる
（このサーバーは直接rootユーザーでの接続が不可となっているため）

キックスタートサーバーIPアドレス
192.168.3.250

・ログインユーザー情報
master
Japwq2R6Aw

・rootユーザー情報
root
WqUiG9MnkH
```


## 3 ソース・DBをキックスタート用パスに設定する

1. 「database.zip」「server.zip」を 「/var/www/html/fd」以下に移動し、既存のものと置き換える

```
File Defender用ソース・DB設置パス：
/var/www/html/fd

File Defenderソースファイルパス：
/var/www/html/fd/server.zip

File Defender DBファイルパス：
/var/www/html/fd/database.zip
```

※サーバーミドルウェアの追加等が発生する場合は/var/www/html/fd/src に格納してください。

※推奨事項

> 置き換え前のソース・DBは最新版の不測の事態に備えて別ディレクトリに退避させておき、旧バージョンでキックスタート構築ができる状態を維持しておくことを推奨します。

退避先パスの事例：/var/www/html/fd/バージョン番号
（既に当該パスに事例があるので参考にしてください）



## 4 DBセッティング用スクリプトの編集

1. /var/www/html/fd/FileDefender_SetUp_SqlList.sql ファイルを開き、今回のアップデートにて追加されるSQLファイルの情報を追記する

```
追記例: 
バージョン1.4.1の場合、下記の１行を最終行 \o の手前に追記する
\i ./Update/1.4.1.sql

FileDefenderDBセッティング用スクリプト
/var/www/html/fd/FileDefender_SetUp_SqlList.sql
```


## 5 FileDefender構築スクリプトファイルの調整

1. 既存の構築スクリプトファイルをコピーして最新バージョン用のスクリプトファイルを生成する

```
# cd /var/www/html/centos/7.1.1503/
# cp ks_x86_64_for_FileDefender_1.4.1_ksver1.0.cfg ks_x86_64_for_FileDefender_1.X.X_ksver1.0.cfg

FileDefender構築スクリプトファイル(ver1.4.1用 ※2020/03/19現在最新)：
/var/www/html/centos/7.1.1503/ks_x86_64_for_FileDefender_1.4.1_ksver1.0.cfg
```

※注意事項

> アップデートにおいて、cronの設定変更やサーバーミドルウェアの追加・および設定値変更等が発生する場合は構築スクリプト内に調整内容を追記してください。具体的な追記・編集内容についてはスクリプト内の同類の操作の記述を参考にしてください。

※推奨事項

> 旧バージョンのスクリプトファイル内のソース・DBのダウンロード先のパスを、③の推奨事項で退避させたパスに調整しておくことで、旧バージョンでのキックスタート構築も引き続き利用可能となります。

```
構築スクリプト内ソースダウンロード箇所
wget http://192.168.3.250/fd/バージョン番号/server.zip -P /usr/local/src/

構築スクリプト内DBダウンロード箇所
wget http://192.168.3.250/fd/バージョン番号/database.zip -P /usr/local/src/
```


## 6 キックスタートラベル（メニュー画面項目）の編集

1. キックスタートラベル定義ファイルに最新バージョン用のラベルを追記する
2. 既存のラベル定義をコピーして「ラベル名(label)」と構築スクリプトへのパス情報を調整する

キックスタートラベル定義ファイル： 
※他の製品構築と共用のファイルなので取り扱いは慎重に！

/tftpboot/pxeboot/pxelinux.cfg/default

```
FileDefender用キックスタートラベル(ver1.4.1用)：
-------------------------------------------------------------

label CentOS7.1.1503-x86_64-FileDefender-ver1.4.1
kernel centos/7.1.1503/x86_64/vmlinuz
append ks=http://192.168.3.250/centos/7.1.1503/ks_x86_64_for_FileDefender_1.4.1_ksver1.0.cfg load initrd=centos/7.1.1503/x86_64/initrd.img devfs=nomount inst.repo=http://192.168.3.250/centos/7.1.1503/x86_64/

-------------------------------------------------------------
```
