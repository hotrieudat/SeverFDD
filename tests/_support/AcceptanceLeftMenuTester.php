<?php


/**
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceLeftMenuTester extends AcceptanceTester
{
    use _generated\AcceptanceTesterActions;

   /**
    * Define custom actions here
    */

    /***
     *
     */
    public function checkClickMenuAndScreenTransition()
    {
        $I = $this;
        $I->comment('ユーザー画面からユーザー画面へは遷移確認不可のため、先に違うリンクをテスト');
        foreach ($I->menuInformation as $num => $u) {
            $I->writeSubjectComment($u[0] . ' をクリック');
            $I->click('li.' . $u[1] . '_menu_selector a');
            $I->wait($I->waitNum);
            $I->seeCurrentUrlEquals('/' . $u[1] . '/');
        }
    }

}
