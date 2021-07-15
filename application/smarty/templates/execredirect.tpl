<!doctype html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=8">
<script>
    function movePage(){
        var loc = "{$url}";
        var msg = "{$message}";
        //メッセージ出力
        alert(msg);
        //元ページへ遷移
        location.href=loc;
    }
</script>
</head>
    <body onload="movePage();">
    </body>
</html>