# ユーザー周りの仕様書（仮）

## 要件定義の内容

* 検索機能
* IPアドレスから場所の逆算機能
* 検索時の表示件数制限

=========================================================
=========================================================


# DBカラム構成

## ログ
* ログID
* ファイル操作時刻
* ユーザーID
* ユーザー名
* ユーザーフリガナ
* ファイルID
* ファイル名
* IPアドレス
* 場所（IPアドレスからの逆算機能）
* 端末のログイン情報
        
    
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

#機能概要

### CSV出力に関してはプロットフレームワークの仕様に従う

### 別途作成が必要な機能について
* [ログのメンテナンス機能](#anchor1)
* [IPアドレスから場所を取得する処理](#anchor2)
* [IPアドレスの逆探知用のDataメンテナンス機能](#anchor3)
* [検索時の件数制御](#anchor4)
    
    
<a id="anchor1"></a>

#### <a href="#anchor1">ログのメンテナンス機能</a>

* 概要
    * システム設定により、指定された期間よりも古いログをCSVファイルに吐き出す
    * CSVファイルとして吐き出したファイルはZipにて圧縮する [^1]
    * 上記CSVファイルが正常に吐き出されたときに吐き出した分のDBのカラムを削除する機能
    
    [^1]: /application/data/log_csv/「作成日時.zip」で吐き出す想定
    
<a id="anchor2"></a>
    
#### <a href="#anchor2">IPアドレスから場所を取得する処理</a>
    
* 概要
    * IPアドレスから場所を国名を取得する処理
    * IPの逆引きに関しては、[GeoIP Legacy PHP API](https://github.com/maxmind/geoip-api-php)とMaxmindのDB情報を利用する想定
    * [IPのデータを定期的に調整する必要あり](#anchor3)
        * CeoIP Legacy PHP APIのライセンス [LGPL-2.1](https://github.com/maxmind/geoip-api-php/blob/master/LICENSE)
        * MaxmindのIP情報のライセンス [Creative Commons Attribution-ShareAlike 4.0 International License.](http://dev.maxmind.com/geoip/legacy/geolite/)
    
    * 以下「GeoIP Legacy PHP API」の環境構築用のメモ
    
        * IPのデータを取得
        ```bash
            cd /usr/share/GeoIP/
            wget http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz
            wget http://geolite.maxmind.com/download/geoip/database/GeoLiteCityv6-beta/GeoLiteCityv6.dat.gz
            gunzip GeoLiteCityv6.dat.gz
            gunzip GeoLiteCity.dat.gz
        ```
        
        * サンプルプログラムを動かす(以下3ファイルを[GitHub](https://github.com/maxmind/geoip-api-php)よりダウンロード

        >
        > geoip.inc
        > geoipcity.inc
        > geoipregionvars.php

        * 下記ソースコードで東京の場所まで取得できることを確認（検証用にプロットの東京のIPを使用）


        ```php
            //必要なライブラリーの利用
            include("./geoipcity.inc");
            include("./geoipregionvars.php");
            
            //ipの設定
            $ip = "61.126.189.39";
            
            //ip4,ip6判定処理
            if((strpos($ip, ":") === false)) {
                //ipv4
                $gi = geoip_open("/usr/share/GeoIP/GeoLiteCity.dat",GEOIP_STANDARD);
                $record = GeoIP_record_by_addr($gi, $ip);
            }
            else {
                //ipv6
                $gi = geoip_open("/usr/share/GeoIP/GeoLiteCityv6.dat",GEOIP_STANDARD);
                $record = GeoIP_record_by_addr_v6($gi, $ip);
            }
            
            //情報取得処理
            print $record->country_code . " " . $record->country_code3 . " " . $record->country_name . "\n";
            print $record->region . " " . $GEOIP_REGION_NAME[$record->country_code][$record->region] . "\n";
            print $record->city . "\n";
            print $record->postal_code . "\n";
            print $record->latitude . "\n";
            print $record->longitude . "\n";
            print $record->metro_code . "\n";
            print $record->area_code . "\n";
            print $record->continent_code . "\n";
            geoip_close($gi);
		```

    
* メモ
    * 当初、peclでセットアップができる[Geo IP](http://php.net/manual/ja/book.geoip.php)を利用しようとしていたが  
        IP6の処理ができないことが分かり、概要に記載したライブラリーを使用する想定
    * 以下環境構築用の参考記事
    [参考記事 1 インストール](http://blog.araishi.com/geoip-php-install/)
    [参考記事 2 エラー解決](https://blog.trippyboy.com/2011/centos/serversmanvps-configure-error-no-acceptable-c-compiler-found-in-path/)
    
<a id="anchor3"></a>
    
#### <a href="#anchor3">IPアドレスの逆探知用のDataメンテナンス機能</a>
    
* 概要
    * 定期的にIPアドレスの逆探知用のデータをメンテナスする処理
    * 1ヵ月に一回Cronでたたく想定（※頻度に関しては調査・検証を行う必要がある）
    * 実装方法に関しては2通り存在する。
        1. 今回利用するデータの提供元が提供しているUpload用プログラム [参考URL](http://dev.maxmind.com/geoip/geoipupdate/)
        1. セットアップに記載した通り、プロット側で独自にwgetするコマンドを作成する方法
    * FileKeyでは、独自にwgetを利用する方法で対応したいと考える。
    * 理由としては、Upload用プログラムがGNUライセンスである。手動で作成してもそれほど苦ではないから
    * ただ、1点懸念点がある。IPｖ6のデータベースがBetaとなっており、将来的にBetaが外れURLが変わるのではないかという問題が懸念される。
        
<a id="anchor4"></a>
    
#### <a href="#anchor4">検索時の件数制御</a>
    
* 概要
    * データの取得件数を制御する処理
        
<a id="anchor5"></a>
    