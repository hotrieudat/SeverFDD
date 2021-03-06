# サーバー側の暗号化周りの仕様メモ（仮）

## 要件定義の内容

- 暗号化を実施したファイルを一覧で表示ができる。
- 一覧から検索ができる。
- 暗号化したファイルの情報について登録ができる。
- 暗号化したファイルの情報を編集することができる。
- 暗号化したファイルの詳細から、ログ画面へ遷移することができる。

=========================================================
=========================================================

# DBカラム構成

## ファイルを管理するマスタのカラム情報について
- ファイルID
- ファイル名
- ファイルパスワード
- 複合可否のフラグ

>
> 登録者・更新者・登録日・更新日に関しては、下記URLを参照
>
> [PlottGenerator リンク](https://192.168.12.200/admin/)
>
> ID/PW plott/plott
>
> ※カラム情報はリンクより確認してください

=================================================
=================================================

# 機能概要

### 新規登録・編集・削除・検索・CSV出力に関してはプロットフレームワークの仕様に従う

### 別途作成が必要な機能について


### クライアントより受け取った情報をもとに、パスワードを作成し、その内容を保存しパスワード情報をログイン中のユーザーIDに紐づく公開鍵情報をもとにクライアントに渡す機能。

- 概要
  - 川中さんの作成した[暗号化方法について](file://///192.168.12.202/kyoto_samba/kawanaka/markdown_docs/encryption_operation.html)に参考

- クライアントに求められる機能
  - パスワードの生成
  - パスワードをログイン中のユーザーの公開鍵で暗号化する方法

- 特記事項
  - 公開鍵にて暗号化する方法は、PHPの関数openssl_public_encryptを利用する、またその際第四引数に「OPENSSL_PKCS1_OAEP_PADDING」を用いる
  - パスワードの長さは、214とする。（※暗号化時のパディングの為）
  - 暗号化処理に関する知識について
    - 参考記事 [URL](http://qiita.com/kunichiko/items/3c0b1a2915e9dacbd4c1)
