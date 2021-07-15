<?php


/**
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceSettingsSetDesignTester extends AcceptanceSettingsTester
{
    use _generated\AcceptanceTesterActions;
    public $_xPathPrefix = '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr';
    public $formElements_forLogo_onSetDesign = [];
    public $formElements_forColor_onSetDesign = [];

    public function construct()
    {
        $I = $this;
        parent::construct();
        $I->formElements_forLogo_onSetDesign = [
            [
                'name' => 'form[logo_login_ext]',
                'nameJp' => 'ログイン画面[日本語]',
                'values' => [
                    [
                        'value' => '0',
                        'label' => '既存',
                        'xPath' => $I->_xPathPrefix . '[1]/td[2]/ul/li[1]/label/input'
                    ],
                    [
                        'value' => '1',
                        'label' => '新規',
                        'xPath' => $I->_xPathPrefix . '[1]/td[2]/ul/li[2]/label/input'
                    ]
                ],
                'imageXPath' => $I->_xPathPrefix . '[1]/td[2]/ul/li[1]/span/img'
            ],
            [
                'name' => 'form[logo_login_e_ext]',
                'nameJp' => 'ログイン画面[その他]',
                'values' => [
                    [
                        'value' => '0',
                        'label' => '既存',
                        'xPath' => $I->_xPathPrefix . '[2]/td[2]/ul/li[1]/label/input'
                    ],
                    [
                        'value' => '1',
                        'label' => '新規',
                        'xPath' => $I->_xPathPrefix . '[2]/td[2]/ul/li[2]/label/input'
                    ]
                ],
                'imageXPath' => $I->_xPathPrefix . '[2]/td[2]/ul/li[1]/span/img'
            ],
            [
                'name' => 'form[logo_header_ext]',
                'nameJp' => 'システムロゴ[ヘッダー]',
                'values' => [
                    [
                        'value' => '0',
                        'label' => '既存',
                        'xPath' => $I->_xPathPrefix . '[3]/td[2]/ul/li[1]/label/input'
                    ],
                    [
                        'value' => '1',
                        'label' => '新規',
                        'xPath' => $I->_xPathPrefix . '[3]/td[2]/ul/li[2]/label/input'
                    ]
                ],
                'imageXPath' => $I->_xPathPrefix . '[3]/td[2]/ul/li[1]/span/img'
            ]
        ];

        $I->formElements_forColor_onSetDesign = [
            [
                'nameJp' => '背景色[ログイン画面]',
                'id' => '#login_color_btn',
                'pickerId' => '#login_select_color'
            ],
            [
                'nameJp' => '背景色[ヘッダー]',
                'id' => '#header_color_btn',
                'pickerId' => '#header_select_color'
            ],
            [
                'nameJp' => '背景色[グローバルメニュー]',
                'id' => '#global_menu_color_btn',
                'pickerId' => '#global_menu_select_color',
                'closeBtnXpath' => '//html/body/div[2]/div[2]/div[2]/div/form/table[2]/tbody/tr[3]/td[2]/div[1]/input[2]'
            ]
        ];
    }
}
