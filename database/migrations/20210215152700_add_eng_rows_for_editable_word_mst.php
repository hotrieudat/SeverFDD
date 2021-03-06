<?php
use Phinx\Migration\AbstractMigration;

class AddEngRowsForEditableWordMst extends AbstractMigration
{
    public function up()
    {
        $_row = '<h1 style="list-style: outside none; margin: 0px 0px 30px; padding: 0px; border: none; line-height: 44.8px; color: rgb(67, 67, 67); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>利用規約</span></h1><p style="list-style: outside none; font-size: 0.95em; margin: 20px 0px; padding: 0px; border: none; line-height: 1.6; color: rgb(67, 67, 67); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>この利用規約（以下，「本規約」といいます。）は，＿＿＿＿＿（以下，「当社」といいます。）がこのウェブサイト上で提供するサービス（以下，「本サービス」といいます。）の利用条件を定めるものです。登録ユーザーの皆さま（以下，「ユーザー」といいます。）には，本規約に従って，本サービスをご利用いただきます。</span></p><h2 style="list-style: outside none; margin: 30px 0px 20px; padding: 0px; border: none; line-height: 33.6px; color: rgb(32, 34, 49); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>第1条（適用）</span></h2><ol style="list-style: outside none; font-size: 16px; margin: 20px 0px 0px 40px; padding: 0px; border: none; color: rgb(67, 67, 67); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>本規約は，ユーザーと当社との間の本サービスの利用に関わる一切の関係に適用されるものとします。</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>当社は本サービスに関し，本規約のほか，ご利用にあたってのルール等，各種の定め（以下，「個別規定」といいます。）をすることがあります。これら個別規定はその名称のいかんに関わらず，本規約の一部を構成するものとします。</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>本規約の規定が前条の個別規定の規定と矛盾する場合には，個別規定において特段の定めなき限り，個別規定の規定が優先されるものとします。</span></li></ol><h2 style="list-style: outside none; margin: 30px 0px 20px; padding: 0px; border: none; line-height: 33.6px; color: rgb(32, 34, 49); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>第2条（利用登録）</span></h2><ol style="list-style: outside none; font-size: 16px; margin: 20px 0px 0px 40px; padding: 0px; border: none; color: rgb(67, 67, 67); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>本サービスにおいては，登録希望者が本規約に同意の上，当社の定める方法によって利用登録を申請し，当社がこれを承認することによって，利用登録が完了するものとします。</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>当社は，利用登録の申請者に以下の事由があると判断した場合，利用登録の申請を承認しないことがあり，その理由については一切の開示義務を負わないものとします。</span><ol style="list-style: outside none; font-size: 15.2px; margin: 20px 0px 20px 40px; padding: 0px; border: none;"><li style="text-align: left; list-style: outside decimal; font-size: 15.2px; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>利用登録の申請に際して虚偽の事項を届け出た場合</span></li><li style="text-align: left; list-style: outside decimal; font-size: 15.2px; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>本規約に違反したことがある者からの申請である場合</span></li><li style="text-align: left; list-style: outside decimal; font-size: 15.2px; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>その他，当社が利用登録を相当でないと判断した場合</span></li></ol></li></ol><h2 style="list-style: outside none; margin: 30px 0px 20px; padding: 0px; border: none; line-height: 33.6px; color: rgb(32, 34, 49); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>第3条（ユーザーIDおよびパスワードの管理）</span></h2><ol style="list-style: outside none; font-size: 16px; margin: 20px 0px 0px 40px; padding: 0px; border: none; color: rgb(67, 67, 67); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>ユーザーは，自己の責任において，本サービスのユーザーIDおよびパスワードを適切に管理するものとします。</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>ユーザーは，いかなる場合にも，ユーザーIDおよびパスワードを第三者に譲渡または貸与し，もしくは第三者と共用することはできません。当社は，ユーザーIDとパスワードの組み合わせが登録情報と一致してログインされた場合には，そのユーザーIDを登録しているユーザー自身による利用とみなします。</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>ユーザーID及びパスワードが第三者によって使用されたことによって生じた損害は，当社に故意又は重大な過失がある場合を除き，当社は一切の責任を負わないものとします。</span></li></ol><h2 style="list-style: outside none; margin: 30px 0px 20px; padding: 0px; border: none; line-height: 33.6px; color: rgb(32, 34, 49); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>第4条（利用料金および支払方法）</span></h2><ol style="list-style: outside none; font-size: 16px; margin: 20px 0px 0px 40px; padding: 0px; border: none; color: rgb(67, 67, 67); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>ユーザーは，本サービスの有料部分の対価として，当社が別途定め，本ウェブサイトに表示する利用料金を，当社が指定する方法により支払うものとします。</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>ユーザーが利用料金の支払を遅滞した場合には，ユーザーは年14．6％の割合による遅延損害金を支払うものとします。</span></li></ol><h2 style="list-style: outside none; margin: 30px 0px 20px; padding: 0px; border: none; line-height: 33.6px; color: rgb(32, 34, 49); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>第5条（禁止事項）</span></h2><p style="list-style: outside none; font-size: 0.95em; margin: 20px 0px; padding: 0px; border: none; line-height: 1.6; color: rgb(67, 67, 67); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>ユーザーは，本サービスの利用にあたり，以下の行為をしてはなりません。</span></p><ol style="list-style: outside none; font-size: 16px; margin: 20px 0px 0px 40px; padding: 0px; border: none; color: rgb(67, 67, 67); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>法令または公序良俗に違反する行為</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>犯罪行為に関連する行為</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>本サービスの内容等，本サービスに含まれる著作権，商標権ほか知的財産権を侵害する行為</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>当社，ほかのユーザー，またはその他第三者のサーバーまたはネットワークの機能を破壊したり，妨害したりする行為</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>本サービスによって得られた情報を商業的に利用する行為</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>当社のサービスの運営を妨害するおそれのある行為</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>不正アクセスをし，またはこれを試みる行為</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>他のユーザーに関する個人情報等を収集または蓄積する行為</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>不正な目的を持って本サービスを利用する行為</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>本サービスの他のユーザーまたはその他の第三者に不利益，損害，不快感を与える行為</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>他のユーザーに成りすます行為</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>当社が許諾しない本サービス上での宣伝，広告，勧誘，または営業行為</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>面識のない異性との出会いを目的とした行為</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>当社のサービスに関連して，反社会的勢力に対して直接または間接に利益を供与する行為</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>その他，当社が不適切と判断する行為</span></li></ol><h2 style="list-style: outside none; margin: 30px 0px 20px; padding: 0px; border: none; line-height: 33.6px; color: rgb(32, 34, 49); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>第6条（本サービスの提供の停止等）</span></h2><ol style="list-style: outside none; font-size: 16px; margin: 20px 0px 0px 40px; padding: 0px; border: none; color: rgb(67, 67, 67); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>当社は，以下のいずれかの事由があると判断した場合，ユーザーに事前に通知することなく本サービスの全部または一部の提供を停止または中断することができるものとします。</span><ol style="list-style: outside none; font-size: 15.2px; margin: 20px 0px 20px 40px; padding: 0px; border: none;"><li style="text-align: left; list-style: outside decimal; font-size: 15.2px; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>本サービスにかかるコンピュータシステムの保守点検または更新を行う場合</span></li><li style="text-align: left; list-style: outside decimal; font-size: 15.2px; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>地震，落雷，火災，停電または天災などの不可抗力により，本サービスの提供が困難となった場合</span></li><li style="text-align: left; list-style: outside decimal; font-size: 15.2px; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>コンピュータまたは通信回線等が事故により停止した場合</span></li><li style="text-align: left; list-style: outside decimal; font-size: 15.2px; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>その他，当社が本サービスの提供が困難と判断した場合</span></li></ol></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>当社は，本サービスの提供の停止または中断により，ユーザーまたは第三者が被ったいかなる不利益または損害についても，一切の責任を負わないものとします。</span></li></ol><h2 style="list-style: outside none; margin: 30px 0px 20px; padding: 0px; border: none; line-height: 33.6px; color: rgb(32, 34, 49); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>第7条（利用制限および登録抹消）</span></h2><ol style="list-style: outside none; font-size: 16px; margin: 20px 0px 0px 40px; padding: 0px; border: none; color: rgb(67, 67, 67); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>当社は，ユーザーが以下のいずれかに該当する場合には，事前の通知なく，ユーザーに対して，本サービスの全部もしくは一部の利用を制限し，またはユーザーとしての登録を抹消することができるものとします。</span><ol style="list-style: outside none; font-size: 15.2px; margin: 20px 0px 20px 40px; padding: 0px; border: none;"><li style="text-align: left; list-style: outside decimal; font-size: 15.2px; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>本規約のいずれかの条項に違反した場合</span></li><li style="text-align: left; list-style: outside decimal; font-size: 15.2px; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>登録事項に虚偽の事実があることが判明した場合</span></li><li style="text-align: left; list-style: outside decimal; font-size: 15.2px; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>料金等の支払債務の不履行があった場合</span></li><li style="text-align: left; list-style: outside decimal; font-size: 15.2px; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>当社からの連絡に対し，一定期間返答がない場合</span></li><li style="text-align: left; list-style: outside decimal; font-size: 15.2px; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>本サービスについて，最終の利用から一定期間利用がない場合</span></li><li style="text-align: left; list-style: outside decimal; font-size: 15.2px; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>その他，当社が本サービスの利用を適当でないと判断した場合</span></li></ol></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>当社は，本条に基づき当社が行った行為によりユーザーに生じた損害について，一切の責任を負いません。</span></li></ol><h2 style="list-style: outside none; margin: 30px 0px 20px; padding: 0px; border: none; line-height: 33.6px; color: rgb(32, 34, 49); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>第8条（退会）</span></h2><p style="list-style: outside none; font-size: 0.95em; margin: 20px 0px; padding: 0px; border: none; line-height: 1.6; color: rgb(67, 67, 67); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>ユーザーは，当社の定める退会手続により，本サービスから退会できるものとします。</span></p><h2 style="list-style: outside none; margin: 30px 0px 20px; padding: 0px; border: none; line-height: 33.6px; color: rgb(32, 34, 49); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>第9条（保証の否認および免責事項）</span></h2><ol style="list-style: outside none; font-size: 16px; margin: 20px 0px 0px 40px; padding: 0px; border: none; color: rgb(67, 67, 67); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>当社は，本サービスに事実上または法律上の瑕疵（安全性，信頼性，正確性，完全性，有効性，特定の目的への適合性，セキュリティなどに関する欠陥，エラーやバグ，権利侵害などを含みます。）がないことを明示的にも黙示的にも保証しておりません。</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>当社は，本サービスに起因してユーザーに生じたあらゆる損害について一切の責任を負いません。ただし，本サービスに関する当社とユーザーとの間の契約（本規約を含みます。）が消費者契約法に定める消費者契約となる場合，この免責規定は適用されません。</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>前項ただし書に定める場合であっても，当社は，当社の過失（重過失を除きます。）による債務不履行または不法行為によりユーザーに生じた損害のうち特別な事情から生じた損害（当社またはユーザーが損害発生につき予見し，または予見し得た場合を含みます。）について一切の責任を負いません。また，当社の過失（重過失を除きます。）による債務不履行または不法行為によりユーザーに生じた損害の賠償は，ユーザーから当該損害が発生した月に受領した利用料の額を上限とします。</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>当社は，本サービスに関して，ユーザーと他のユーザーまたは第三者との間において生じた取引，連絡または紛争等について一切責任を負いません。</span></li></ol><h2 style="list-style: outside none; margin: 30px 0px 20px; padding: 0px; border: none; line-height: 33.6px; color: rgb(32, 34, 49); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>第10条（サービス内容の変更等）</span></h2><p style="list-style: outside none; font-size: 0.95em; margin: 20px 0px; padding: 0px; border: none; line-height: 1.6; color: rgb(67, 67, 67); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>当社は，ユーザーに通知することなく，本サービスの内容を変更しまたは本サービスの提供を中止することができるものとし，これによってユーザーに生じた損害について一切の責任を負いません。</span></p><h2 style="list-style: outside none; margin: 30px 0px 20px; padding: 0px; border: none; line-height: 33.6px; color: rgb(32, 34, 49); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>第11条（利用規約の変更）</span></h2><p style="list-style: outside none; font-size: 0.95em; margin: 20px 0px; padding: 0px; border: none; line-height: 1.6; color: rgb(67, 67, 67); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>当社は，必要と判断した場合には，ユーザーに通知することなくいつでも本規約を変更することができるものとします。なお，本規約の変更後，本サービスの利用を開始した場合には，当該ユーザーは変更後の規約に同意したものとみなします。</span></p><h2 style="list-style: outside none; margin: 30px 0px 20px; padding: 0px; border: none; line-height: 33.6px; color: rgb(32, 34, 49); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>第12条（個人情報の取扱い）</span></h2><p style="list-style: outside none; font-size: 0.95em; margin: 20px 0px; padding: 0px; border: none; line-height: 1.6; color: rgb(67, 67, 67); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>当社は，本サービスの利用によって取得する個人情報については，当社「プライバシーポリシー」に従い適切に取り扱うものとします。</span></p><h2 style="list-style: outside none; margin: 30px 0px 20px; padding: 0px; border: none; line-height: 33.6px; color: rgb(32, 34, 49); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>第13条（通知または連絡）</span></h2><p style="list-style: outside none; font-size: 0.95em; margin: 20px 0px; padding: 0px; border: none; line-height: 1.6; color: rgb(67, 67, 67); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>ユーザーと当社との間の通知または連絡は，当社の定める方法によって行うものとします。当社は,ユーザーから,当社が別途定める方式に従った変更届け出がない限り,現在登録されている連絡先が有効なものとみなして当該連絡先へ通知または連絡を行い,これらは,発信時にユーザーへ到達したものとみなします。</span></p><h2 style="list-style: outside none; margin: 30px 0px 20px; padding: 0px; border: none; line-height: 33.6px; color: rgb(32, 34, 49); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>第14条（権利義務の譲渡の禁止）</span></h2><p style="list-style: outside none; font-size: 0.95em; margin: 20px 0px; padding: 0px; border: none; line-height: 1.6; color: rgb(67, 67, 67); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>ユーザーは，当社の書面による事前の承諾なく，利用契約上の地位または本規約に基づく権利もしくは義務を第三者に譲渡し，または担保に供することはできません。</span></p><h2 style="list-style: outside none; margin: 30px 0px 20px; padding: 0px; border: none; line-height: 33.6px; color: rgb(32, 34, 49); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>第15条（準拠法・裁判管轄）</span></h2><ol style="list-style: outside none; font-size: 16px; margin: 20px 0px 0px 40px; padding: 0px; border: none; color: rgb(67, 67, 67); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>本規約の解釈にあたっては，日本法を準拠法とします。</span></li><li style="text-align: left; list-style: outside decimal; font-size: 0.95em; margin: 10px 0px 0px; padding: 0px; border: none; line-height: 21.28px;"><span>本サービスに関して紛争が生じた場合には，当社の本店所在地を管轄する裁判所を専属的合意管轄とします。</span></li></ol><p class="tR" style="text-align: right; list-style: outside none; font-size: 0.95em; margin: 30px 0px 0px; padding: 0px; border: none; line-height: 21.28px; color: rgb(67, 67, 67); font-family: YuGothic, Meiryo, Hiragino Kaku Gothic ProN, Arial, Helvetica, sans-serif;"><span>以上</span></p>';
        $this->execute("
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_EXPIRATION_NOTIFICATION_MAIL_BODY', '02', 'パスワードの有効期限が近づいています。
     ユーザー画面のパスワード更新画面からパスワードを変更してください。
     
     以下のユーザーが対象となります。
     ユーザー名：[NAME]
     ID：[LOGIN]
     企業名：[COMPANY]
     
     パスワード最終変更日時：[LAST_UPDATE]
     パスワード有効期限：[DEADLINE]
     
     -------------------------------------------------------
     ※本メールは送信専用となっておりますので、返信はしないでください。
     ', 'パスワードの有効期限が近づいています。
     ユーザー画面のパスワード更新画面からパスワードを変更してください。
     
     以下のユーザーが対象となります。
     ユーザー名：[NAME]
     ID：[LOGIN]
     企業名：[COMPANY]
     
     パスワード最終変更日時：[LAST_UPDATE]
     パスワード有効期限：[DEADLINE]
     
     -------------------------------------------------------
     ※本メールは送信専用となっておりますので、返信はしないでください。
     ');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUED_NOTIFICATION_MAIL_BODY', '02', '【File Key】ログイン情報のお知らせ。
     パスワードが再設定されました。
     
     初期パスワード：[PASS]
     URL：[URL]
     
     -------------------------------------------------------
     ※本メールは送信専用となっておりますので、返信はしないでください。
     ', '【File Key】ログイン情報のお知らせ。
     パスワードが再設定されました。
     
     初期パスワード：[PASS]
     URL：[URL]
     
     -------------------------------------------------------
     ※本メールは送信専用となっておりますので、返信はしないでください。
     ');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('ERROR_MAIL_TITLE', '02', 'File Defenderサーバーの登録処理でエラーが発生しました', 'File Defenderサーバーの登録処理でエラーが発生しました');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('ERROR_MAIL_BODY', '02', 'File Defenderサーバーの登録処理でエラーが発生しました。', 'File Defenderサーバーの登録処理でエラーが発生しました。');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('DEFAULT_FROM', '02', 'admin@filedefender.jp', 'admin@filedefender.jp');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_LDAP_ERROR_MAIL_FROM', '02', '[MAIL]', '[MAIL]');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_LDAP_ERROR_MAIL_BODY', '02', 'ご依頼のユーザーはLDAP認証を行っていますので、パスワード再発行を受け付けていません。
     以下のURLからログインしてください。
     URL：[URL]
     
     -------------------------------------------------------
     ※本メールは送信専用となっておりますので、返信はしないでください。
     ', 'ご依頼のユーザーはLDAP認証を行っていますので、パスワード再発行を受け付けていません。
     以下のURLからログインしてください。
     URL：[URL]
     
     -------------------------------------------------------
     ※本メールは送信専用となっておりますので、返信はしないでください。
');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_EXPIRATION_NOTIFICATION_MAIL_FROM', '02', '[MAIL]', '[MAIL]');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('TERMS_MESSAGE', '02', '" . $_row . "', '');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('FIRST_NOTIFICATION_MAIL_FROM', '02', '[MAIL]', '[MAIL]');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('FIRST_NOTIFICATION_MAIL_TITLE', '02', 'File Defender へようこそ', 'File Defender へようこそ');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_MAIL_FROM', '02', '[MAIL]', '[MAIL]');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_MAIL_BODY', '02', 'パスワード再発行の依頼が行われました。
     下記URLへアクセスいただく事で、パスワードが再設定されます。
     
     パスワード再発行用URL：[URL]
     
     パスワードの再発行URLは、お申し込みから24時間に限り有効です。
     有効期限を経過しますと無効となりますのでご注意ください。
     
     -------------------------------------------------------
     ※本メールは送信専用となっておりますので、返信はしないでください。
     ', 'パスワード再発行の依頼が行われました。
     下記URLへアクセスいただく事で、パスワードが再設定されます。
     
     パスワード再発行用URL：[URL]
     
     パスワードの再発行URLは、お申し込みから24時間に限り有効です。
     有効期限を経過しますと無効となりますのでご注意ください。
     
     -------------------------------------------------------
     ※本メールは送信専用となっておりますので、返信はしないでください。
');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUED_NOTIFICATION_MAIL_TITLE', '02', '【File Defender】ログイン情報のお知らせ', '【File Defender】ログイン情報のお知らせ');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('D_FILE_DEFENDER', '02', 'File Defender', 'File Defender');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('MISUSE_ALERT_MAIL_BODY', '02', '設定された不正使用の疑いのある操作が実行されました。
     
     ファイル：[FILE]
     操作：[OPERATION]
     操作ユーザー：[UESR]
     所属企業：[COMPANY]
     実行時間：[DATE]
     
     
     -------------------------------------------------------
     ※本メールは送信専用となっておりますので、返信はしないでください。
     ', '設定された不正使用の疑いのある操作が実行されました。
     
     ファイル：[FILE]
     操作：[OPERATION]
     操作ユーザー：[UESR]
     所属企業：[COMPANY]
     
     
     -------------------------------------------------------
     ※本メールは送信専用となっておりますので、返信はしないでください。
');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('FILE_ALERT_MAIL_TITLE', '02', '【File Defender】ユーザー監視レポート', '【File Defender】ユーザー監視レポート');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('FILE_ALERT_MAIL_FROM', '02', '[MAIL]', '[MAIL]');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('FILE_ALERT_MAIL_BODY', '02', '[DATE] のユーザー監視レポートです。
     指定のファイルに対して、登録された監視ユーザーが実行した指定動作を、添付ファイルにリストアップしています。
     詳細は、添付されているCSVファイルをご参照ください。
     
     -------------------------------------------------------
     ※本メールは送信専用となっておりますので、返信はしないでください。
     ', '[DATE] のユーザー監視レポートです。
     指定のファイルに対して、登録された監視ユーザーが実行した指定動作を、添付ファイルにリストアップしています。
     詳細は、添付されているCSVファイルをご参照ください。
     
     -------------------------------------------------------
     ※本メールは送信専用となっておりますので、返信はしないでください。
');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('FILE_ALERT_NOUSE_MAIL_BODY', '02', '[DATE] のユーザー監視レポートです。
     指定のファイルに対して、登録された監視ユーザーが実行した指定動作は実施されませんでした。
     
     -------------------------------------------------------
     ※本メールは送信専用となっておりますので、返信はしないでください。
     ', '[DATE] のユーザー監視レポートです。
     指定のファイルに対して、登録された監視ユーザーが実行した指定動作は実施されませんでした。
     
     -------------------------------------------------------
     ※本メールは送信専用となっておりますので、返信はしないでください。
');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_MAIL_TITLE', '02', '【File Defender】パスワード再発行のお知らせ', '【File Defender】パスワード再発行のお知らせ');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('FIRST_NOTIFICATION_MAIL_BODY', '02', 'あなたへ File Defender への招待がありました。
     
     ID：[LOGIN]
     パスワード：[PASS]
     URL：[URL]
     
     
     -------------------------------------------------------
     ※本メールは送信専用となっておりますので、返信はしないでください。
     ', 'あなたへ File Defender への招待がありました。
     
     ID：[LOGIN]
     パスワード：[PASS]
     URL：[URL]
     
     
     -------------------------------------------------------
     ※本メールは送信専用となっておりますので、返信はしないでください。
');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_NOTIFICATION_MAIL_TITLE', '02', '【File Defender】パスワード再発行完了のお知らせ', '【File Defender】パスワード再発行完了のお知らせ');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_NOTIFICATION_MAIL_BODY', '02', 'パスワードが再設定されました。
     
     初期パスワード：[PASS]
     URL：[URL]
     
     -------------------------------------------------------
     ※本メールは送信専用となっておりますので、返信はしないでください。
     ', '【File Defender】ログイン情報のお知らせ。
     パスワードが再設定されました。
     
     初期パスワード：[PASS]
     URL：[URL]
     
     -------------------------------------------------------
     ※本メールは送信専用となっておりますので、返信はしないでください。
');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_LDAP_ERROR_MAIL_TITLE', '02', '【File Defender】パスワード再発行のお知らせ', '【File Defender】パスワード再発行のお知らせ');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_EXPIRATION_NOTIFICATION_MAIL_TITLE', '02', '【File Defender】パスワードの有効期限が近づいています', '【File Defender】パスワードの有効期限が近づいています');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('ERROR_MAIL_FROM', '02', '[MAIL]', '[MAIL]');
");
    }

    public function down()
    {
        $this->execute("
DELETE FROM public.editable_word_mst WHERE language_id = '02' AND editable_word_id != 'PASSWORD_REISSUE_NOTIFICATION_MAIL_TITLE';
");
    }
}
