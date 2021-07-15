<?php
use Phinx\Migration\AbstractMigration;

class UpdateMailTemplate extends AbstractMigration
{
    public function up()
    {
        // 末尾の改行を足す
        $this->execute("
UPDATE public.editable_word_mst SET editable_word = 'パスワードが再設定されました。

初期パスワード：[PASS]
URL：[URL]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
', default_editable_word = '【File Defender】ログイン情報のお知らせ。
パスワードが再設定されました。

初期パスワード：[PASS]
URL：[URL]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
' WHERE editable_word_id = 'PASSWORD_REISSUE_NOTIFICATION_MAIL_BODY' AND language_id = '01';");

    }

    public function down()
    {
        // 末尾の改行を無くす
        $this->execute("
UPDATE public.editable_word_mst SET editable_word = 'パスワードが再設定されました。

初期パスワード：[PASS]
URL：[URL]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
', default_editable_word = '【File Defender】ログイン情報のお知らせ。
パスワードが再設定されました。

初期パスワード：[PASS]
URL：[URL]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。' WHERE editable_word_id = 'PASSWORD_REISSUE_NOTIFICATION_MAIL_BODY' AND language_id = '01';");
    }
}
