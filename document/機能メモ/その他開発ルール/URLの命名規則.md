# URLの命名規則について

## ルール草案

- PHPのAction名に関してはcamelCalseを利用する　⇒　実際のURLに関してはchain-caseとなる
- 既存のPFWで用意されているアクションは、そのまま利用する
  - index 一覧、TOPページ
  - regist 新規登録ページ
  - udpate 更新登録ページ
  - delete 削除処理
  - list 一覧取得
  - search 検索方法のセッション登録
  - login ログイン処理
- 新たにURLを作成する場合は、「動詞」＋「目的語」となるように作成する
  - searchXXXX　→ 検索を目的とした
  - registerXXXXX → Insertをベースとした処理
  - updateXXXX → Updateをベースとした処理
- クライアントソフトからの通信に関してはAPI/xxxxとするようにする
  - URLはフロントコントローラーにてAPIという文字列を削除し各種コントローラーに振り分ける想定
    - https://filekey/API/User/register-xxxxx/ の場合、UserコントローラーのregisterXXXXXというアクションに振り分けられる。
