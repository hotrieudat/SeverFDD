# 開発概要
File Defenderは、ファイルの暗号化・追跡システムです。
File Defender用のWindowsの[常駐クライアント](http://192.168.12.40/k-wako/FileDefenderClient-CSharp)を利用し、暗号化・復号を行います。

# 簡易構築
```
# ソースファイル取得
yum -y install git
cd /var
clone http://192.168.12.40/k-kawanaka/FileKey.git www
git checkout master
git pull

# ※フォルダが存在しない場合以下を実行する
mkdir -m 777 /var/www/application/smarty/templates_c

# DB反映
cd www/database
chmod 777 pseudo_migrate.sh
./pseudo_migrate.sh
```
