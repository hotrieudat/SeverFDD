<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    public $searchModalInformation = [];
    public $menuInformation = [
        ['ユーザーグループ', 'user-groups'],
        ['ユーザー', 'user'],
        ['プロジェクト', 'projects'],
        ['ログ', 'summarize-log'],
        ['アプリケーション情報', 'application-control'],
        ['システム設定', 'system']
    ];

    public $waitNum = 1;
    public $count = 0;
    public $childCount = 0;

   /**
    * Define custom actions here
    */

    /**
     * @param $login_code
     * @param $password
     * @param $isClient
     * @param $ldap_id
     * @param bool $isNotPreparatoryOperation
     */
    public function ajaxLogin($login_code, $password, $isClient, $ldap_id, $isNotPreparatoryOperation=true)
    {
        $I = $this;
        $I->amOnPage('/');
        if ($isNotPreparatoryOperation) {
            $I->comment('フォーム操作');
        }
        $I->fillField('login_code', $login_code);
        $I->fillField('password', $password);
        if ($isClient && $isClient !== '') {
            $I->fillField('client', $isClient);
        }
        if ($ldap_id && $ldap_id !== '') {
            $I->fillField('ldap_id', $ldap_id);
        }
        if ($isNotPreparatoryOperation) {
            $I->comment('ログインボタンクリック');
        }
        $I->click('.login_button');
    }

    /**
     * 各画面のテストを実施するにあたり、ログインしていないと
     * 404 が返却されるため、成功する処理をメソッド化しておく
     *
     * @param bool $isNotPreparatoryOperation
     */
    public function successAjaxLogin_admin($isNotPreparatoryOperation=true)
    {
        $I = $this;
        if ($isNotPreparatoryOperation) {
            $I->comment('ログインする');
        }
        $I->ajaxLogin('admin', 'admin', '', '', $isNotPreparatoryOperation);
        // Ajaxのレスポンス待ち時間
        $I->wait($I->waitNum);
        if ($isNotPreparatoryOperation) {
            $I->comment('ユーザー画面に遷移する');
        }
        $I->amOnPage('/user/');
        if ($isNotPreparatoryOperation) {
            $I->see('ユーザー', '.page_title');
        } else {
            $I->wait($I->waitNum);
        }
    }

    /**
     * successAjaxLogin_admin() を事前処理として呼ぶために、コメントを足したメソッド
     */
    public function construct()
    {
        $I = $this;
        $I->comment('[start] 事前処理 管理者としてログイン');
        $I->successAjaxLogin_admin(false);
        $I->comment('[ end ] 事前処理 / admin after login なのでユーザー画面が開いている状態');
    }

    /**
     * @param array $searchModalInformation
     */
    public function setSearchModalInformation($searchModalInformation=[])
    {
        $I = $this;
        $I->searchModalInformation = $searchModalInformation;
    }

    /**
     * @param int $menuInfoKey
     */
    public function clickTargetOnLeftMenu($menuInfoKey=0)
    {
        $I = $this;
        $I->writeSubjectComment($I->menuInformation[$menuInfoKey][0] . 'をクリック');
        $I->click('li.' . $I->menuInformation[$menuInfoKey][1] . '_menu_selector a');
        $I->wait($I->waitNum);
        $I->seeCurrentUrlEquals('/' . $I->menuInformation[$menuInfoKey][1] . '/');
        $I->see($I->menuInformation[$menuInfoKey][0], '.page_title');
    }

    /**
     *
     */
    public function headerMenuOpen()
    {
        $I = $this;
        $I->click('div.userMenu');
        $I->wait($I->waitNum);
        $I->see('端末設定', 'a.devices');
        $I->see('パスワード更新', 'a.password');
        $I->see('マニュアル', '//a[@id="openManual"]');
        $I->see('ログアウト', 'a.logout');
    }

    /**
     * @param string $currentPath
     */
    public function logoutByHeader($currentPath='/summarize-log/')
    {
        $I = $this;
        // 最低権限でのログインを前提として、ログ画面にしておく
        $I->amOnPage($currentPath);
        $I->wait($I->waitNum);
        $I->headerMenuOpen();
        $I->wait($I->waitNum);
        $I->click('a.logout');
        $I->wait($I->waitNum);
        $I->seeCurrentUrlEquals('/');
        $I->see('ファイル暗号化&トレースシステム', '.login_title');
    }

    /**
     * logoutByHeader を事後処理として呼ぶためのメソッド
     *
     * @param string $currentPath
     */
    public function destruct($currentPath='/user/')
    {
        $I = $this;
        $I->comment('[start] 事後処理 次のシナリオ用にログアウト');
        $I->logoutByHeader($currentPath);
        $I->comment('[ end ] 事後処理 次のシナリオ用にログアウト');
        $I->wait($I->waitNum);
    }


    /**
     * 当該テストが何項目あったかを出力
     *
     * @param int $count
     */
    public function before_destruct($count=null)
    {
        $I = $this;
        if (is_null($count)) {
            $count = $I->count;
        }
        $I->comment('[sub total] ' . $count . 'の項目をチェック');
        $I->wait($I->waitNum);
    }

    /**
     * @param int|string $count
     * @param string $targetSelector
     * @param string $targetNameJp
     * @param array $seeElements
     */
    public function mouseOver_andSee($count=0, $targetSelector='', $targetNameJp='', $seeElements=[], $isNotFirst=true)
    {
        $I = $this;
        $I->comment('[' . $count . '] ' . $targetNameJp . 'にオンマウス');
        $I->moveMouseOver($targetSelector);
        $I->wait($I->waitNum);
        if (!$isNotFirst) {
            foreach ($seeElements as $seeElement) {
                if (!is_array($seeElement)) {
                    $I->seeElement($seeElement);
                } else {
                    $I->see($seeElement[0], $seeElement[1]);
                }
            }
        }
    }

    /**
     * @param string $strComment
     */
    public function writeSubjectComment($strComment='')
    {
        $I = $this;
        $I->count++;
        // reset
        $I->childCount = 0;
        $I->comment('■ [' . $I->count . '] ' . $strComment);
    }

    /**
     * @param string $strComment
     */
    public function writeChildSubjectComment($strComment='')
    {
        $I = $this;
        $I->childCount++;
        $I->comment('□□ [' . $I->count . '-' . $I->childCount . '] ' . $strComment);
    }

    /**
     * @param $btnSelector
     * @param string $returnUrl
     * @param bool $isExecuteJS
     */
    public function checkClickBackButtonToReturnPage($btnSelector, $returnUrl='', $isExecuteJS=true)
    {
        $I = $this;
        $I->comment('戻る クリック');
        $I->click($btnSelector);
        if ($isExecuteJS) {
            $I->executeJS('fncBackIndexPage();');
        }
        $I->wait($I->waitNum);
        $I->writeChildSubjectComment('画面遷移を確認');
        $I->seeCurrentUrlEquals($returnUrl);
    }

    public function appendPseudoName_andMoveToFrame($_frameName='_currentModal')
    {
        $I = $this;
        $I->writeChildSubjectComment('モーダル内の Iframe に移動');
        $I->executeJS('$(".dhx_cell_cont_wins iframe").attr("name","' . $_frameName . '")');
        $I->wait($I->waitNum);
        $I->switchToIFrame($_frameName);
        $I->wait($I->waitNum);
    }

    /**
     * @param string $btnSelector
     */
    public function openSearchModal($btnSelector='')
    {
        $I = $this;
        $I->writeSubjectComment($I->searchModalInformation['subject']);
        $I->wait($I->waitNum);
        $currentButtonSelector = (!empty($btnSelector)) ? $btnSelector : 'span.search_icon';
        $I->click($currentButtonSelector);
        $I->wait($I->waitNum);
        $I->writeChildSubjectComment('モーダルが開いていることを確認');
        $I->see($I->searchModalInformation['frameTitle'], '.dhxwin_text_inside');
        $I->appendPseudoName_andMoveToFrame($I->searchModalInformation['frameName']);
        $I->amOnPage($I->searchModalInformation['frameUrl']);
    }

    /**
     */
    public function afterCloseModal()
    {
        $I = $this;
        $I->writeChildSubjectComment('モーダルが閉じていることを確認');
        $I->dontSee($I->searchModalInformation['frameTitle'], '.dhxwin_text_inside');
        $I->writeChildSubjectComment('モーダル内の Iframe から親 Window に移動');
        $I->switchToIFrame();
        $I->amOnPage($I->searchModalInformation['currentUrl']);
        $I->wait($I->waitNum);
    }

    /**
     */
    public function checkSearch_withClickSearchBtn()
    {
        $I = $this;
        $I->searchModalInformation['subject'] = '検索をクリック -> 検索をクリック';
        $I->openSearchModal();
        $I->writeChildSubjectComment('検索をクリック');
        $I->click('//input[@id="search"]');
        $I->wait($I->waitNum);
        $I->afterCloseModal();
    }

    /**
     */
    public function checkSearch_withClickCloseBtn()
    {
        $I = $this;
        $I->searchModalInformation['subject']  = '検索をクリック -> 閉じるをクリック';
        $I->openSearchModal();
        $I->writeChildSubjectComment('閉じるをクリック');
        $I->click('//input[@id="clear"]');
        $I->wait($I->waitNum);
        $I->afterCloseModal();
    }

    /**
     * @param string $confirmSentence
     * @param string $textSelector
     * @param string $noBtnSelector
     */
    public function checkDisplayConfirm_andClickNo($confirmSentence='', $textSelector='.dhtmlx_popup_text span', $noBtnSelector='//div[@result="false"]')
    {
        $I = $this;
        $I->writeChildSubjectComment('Confirm 出力を確認');
        $I->see($confirmSentence, $textSelector);
        $I->wait($I->waitNum);
        $I->writeChildSubjectComment('いいえ をクリック');
        $I->click($noBtnSelector);
        $I->dontSee($confirmSentence, $textSelector);
    }

    /**
     * @param string $errorSentence
     * @param string $textSelector
     * @param string $okBtnSelector
     */
    public function checkDisplayError_andClickOk($errorSentence='', $textSelector='.dhtmlx_popup_text span', $okBtnSelector='//div[@result="true"]')
    {
        $I = $this;
        $I->writeChildSubjectComment('エラー出力を確認');
        $I->see($errorSentence, $textSelector);
        $I->wait($I->waitNum);
        $I->writeChildSubjectComment('OK をクリック');
        $I->click($okBtnSelector);
        $I->wait($I->waitNum);
        $I->dontSee($errorSentence, $textSelector);
    }

    public function checkClickToScreenTransition($_params = [])
    {
        $I = $this;
        $I->writeChildSubjectComment($_params['name'] . ' クリック');
        $I->click($_params['buttonSelector']);
        $I->wait($I->waitNum);
        $I->writeChildSubjectComment('画面遷移 確認');
        $I->seeCurrentUrlEquals($_params['afterTheTransition']);
        $I->see($_params['nextName'], '.page_title');
    }

    /**
     * @param array $_params
     */
    public function selectGridRow($_params = [])
    {
        $I = $this;
        $I->writeSubjectComment($_params['gridName'] . ' 選択 → 権限グループ更新 クリック → 画面遷移');
        $I->writeChildSubjectComment($_params['gridName'] . ' クリック');
        $I->click($_params['gridSelector']);
        $I->wait($I->waitNum);
    }

    /**
     * radio ボタン の 選択をチェックする
     *
     * @param string $value
     * @param string $label
     * @param string $xPath
     * @param string $elementNameJp
     */
    public function checkRadio($value='', $label='', $xPath='', $elementNameJp='')
    {
        $I = $this;
        $I->writeChildSubjectComment($elementNameJp . ':ラジオボタン ' . $label . ' 選択');
        $option = $I->grabTextFrom($xPath);
        $I->selectOption($xPath, $value);
        $I->wait($I->waitNum);
        $I->checkOption($option);
    }

    /**
     * @NOTE 複数画面で実装されており、また増える可能性も加味し、このファイルにおいておく
     * カレンダー入力を実装した場合は、 t2120_ServerLogCallendarEntryOnCompanySearchCept.php 等を参考にして、
     * このメソッドを呼び出すことで、テスト可能。
     *
     * @param string $dateFormSelector
     * @param int $dialogKey
     */
    public function checkCalendarEntry($dateFormSelector='', $dialogKey=3)
    {
        $I = $this;
        $I->writeSubjectComment('入力要素クリック → カレンダー出力 確認');
        $I->writeChildSubjectComment('入力要素クリック');
        $I->seeElement($dateFormSelector);
        $I->click($dateFormSelector);
        $I->wait($I->waitNum);
        $I->writeChildSubjectComment('カレンダー出力 確認');
        $I->seeElement('.dhtmlxcalendar_in_input');

        $_dt = ['2020', '12', '20'];
        $_hi = ['12', '00', '00'];
        $_entryDate = implode('/', $_dt) . ' ' . implode(':', $_hi);
        $I->writeSubjectComment('日時 直接入力 確認');
        $I->fillField($dateFormSelector, $_entryDate);

        $I->writeSubjectComment('直接入力日時 反映 確認');
        $I->seeElement('//html/body/div[' . $dialogKey . ']');
        $_pp = '//html/body/div[' . $dialogKey . ']/div/';
        $I->see($_dt[0], $_pp . 'div[1]/ul/li/span/span[1]');
        $I->see($_dt[1] . '月', $_pp . 'div[1]/ul/li/span/span[2]');
        $I->see($_dt[2], $_pp . 'div[3]/ul[4]/li[2]/div');
        $I->see($_hi[0], $_pp . 'div[4]/ul/li/span[1]');
        $I->see($_hi[1], $_pp . 'div[4]/ul/li/span[3]');

        $I->writeSubjectComment('カレンダー入力 → 入力日時 反映 確認');
        $_dt = ['2019', '11', '19'];
        $_hi = ['11', '55', '00'];

        $I->writeChildSubjectComment('クリック：年 → ' . $_dt[0] . ' クリック');
        $I->click($_pp . 'div[1]/ul/li/span/span[1]');
        $I->wait($I->waitNum);
        $I->click($_pp . 'div[6]/table/tbody/tr/td[2]/div/ul[2]/li[1]');
        $I->wait($I->waitNum);

        $I->writeChildSubjectComment('クリック：月 → ' . $_dt[1] . '月 クリック');
        $I->click($_pp . 'div[1]/ul/li/span/span[2]');
        $I->wait($I->waitNum);
        $I->click($_pp . 'div[6]/table/tbody/tr/td[2]/div[2]/ul[4]/li[2]');
        $I->wait($I->waitNum);

        $I->writeChildSubjectComment('クリック：時 → ' . $_hi[0] . '時 クリック');
        $I->click($_pp . 'div[4]/ul/li/span[1]');
        $I->wait($I->waitNum);
        $I->click($_pp . 'div[6]/table/tbody/tr/td[2]/div/ul[2]/li[6]');
        $I->wait($I->waitNum);

        $I->writeChildSubjectComment('クリック：分 → ' . $_hi[1] . '分 クリック');
        $I->click($_pp . 'div[4]/ul/li/span[3]');
        $I->wait($I->waitNum);
        $I->click($_pp . 'div[6]/table/tbody/tr/td[2]/div[4]/ul[4]/li[3]');
        $I->wait($I->waitNum);

        $I->writeChildSubjectComment($_dt[2] . '日 クリック');
        $I->click($_pp . 'div[3]/ul[4]/li[4]/div');
        $I->wait($I->waitNum);

        $_entryDate = implode('/', $_dt) . ' ' . implode(':', $_hi);
        $I->seeInField($dateFormSelector, $_entryDate);
    }
}
