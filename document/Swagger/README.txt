SWAGGER-UI の代替ログイン（security: - basicAuth）に使用可能なユーザ
■ super admin
'000001', 'admin'
■ 通常のユーザー（権限やhost/guest違い）
'900001', 'testuser900001'
'900002', 'testuser900002'
'900003', 'testuser900003'
'900006', 'testuser900006'
'900007', 'testuser900007'
'900008', 'testuser900008'
■ クライアントからアクセスするためのユーザー
（本来はクライアントからアクセス可能なユーザならだれでも良いが
代替ログインの都合上別途用意しています）
'900005', 'clientuser900005',
ここまで、パスワードは全て admin です。

■ LDAP連携ユーザ
'900004', 'sample_taro@kyoto.local'
パスワードは Sampleuser1 です。
※ 最新の値は以下参照
http://192.168.12.40/kyoto/FileDefender/wikis/Active-Directory-%E6%83%85%E5%A0%B1#kyoto

-----------------------------------------------------------------------------------------------
コンテナ起動方法

# 1枚目のPowerShell
# 設場パスを指定
# この例では、Windows のログインユーザー Dir 配下（PowerShell初期位置）からのパスを指定しています。
cd .\codes\filekeys
docker compose down
docker builder prune
docker system prune -a
docker network create swagger_link
docker-compose up --build

# 2枚目のPowerShell
# こちらも前述同様で、yaml の設場に docker-compose を配置しています。
cd .\codes\filekeys\document\Swagger
docker-compose up