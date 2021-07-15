<?php
/**
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2018/07/19
 * Time: 11:39
 */


class VersionTest extends PHPUnit_Framework_TestCase
{

    public function SetUp()
    {

    }

    /**
     *
     * @dataProvider provideTestGetDigits
     * @see          provideTestGetDigits
     * @param int $expected 求める結果(渡したバージョン情報の桁数)
     * @param string $test バージョンの情報
     */
    public function testGetDigits($expected, $test)
    {
        $version = new PloService_Version_Version($test);
        $this->assertEquals($expected, $version->getDigits());
    }

    /**
     * @see testGetDigits
     * @return array
     */
    public function provideTestGetDigits()
    {
        return [
            [1, "1.1"]
            , [2, "1.1.1"]
            , [3, "1.1.1.1"]
            , [4, "1.1.1.1.1"]
            , [2, "1.10.8"]
            , [3, "5.8.0.1"]
        ];
    }

    /**
     * @dataProvider provideTestAlignmentDigits
     * @see          provideTestAlignmentDigits
     * @param string $expected 求める結果(バージョンのテキスト）
     * @param int $test テストする関数に引き渡す値
     * @param string $version オブジェクト生成時に渡すバージョン
     */
    public function testAlignDigits($expected, $test, $version)
    {
        $version = new PloService_Version_Version($version);
        $this->assertEquals($expected, $version->alignDigits($test));
    }

    /**
     * @see testAlignmentDigits
     * @return array
     */
    public function provideTestAlignmentDigits()
    {
        return [
            ["1.1.0", 1, "1.1.0"],
            ["1.1.1", 2, "1.1.1"],
            ["1.2.1.0", 3, "1.2.1"],
            ["1.4.5.0.0", 4, "1.4.5"],
            ["1.4.0.0.0.0", 5, "1.4"]
        ];
    }

    /**
     * 関数 isNewerThanのテストメソッド
     * @dataProvider provideTestIsNewerThan
     * @see          provideTestIsNewerThan
     * @param $expected
     * @param $version
     * @param $compare_version
     */
    public function testIsNewerThan($expected, $version, $compare_version)
    {
        $main = new PloService_Version_Version($version);
        $this->assertSame($expected, $main->isNewerThan(new PloService_Version_Version($compare_version)));
    }

    /**
     * 関数 testIsNewerThan 用のデータプロパイダ
     * @see testIsNewerThan
     * @return array
     */
    public function provideTestIsNewerThan()
    {
        return [
            [true, "1.2.0", "1.1.0"],
            [true, "1.2.1", "1.2.0"],
            [false, "1.2.0", "1.2.0"],
            [false, "1.2.0", "1.3.0"],
            [false, "1.4.3", "1.4.4"],
            [true, "1.2.0", "1.1"],
            [true, "2.1.0", "2.0.9"],
            [false, "3.0.0", "3.0"],
            [false, "3.0", "3"],
            [false, "4.1", "4.2"],
            [false, "4.2.0", "4.3"]
        ];
    }

    /**
     * @dataProvider provideTestIsEqualsTo
     * @see provideTestIsEqualsTo
     * @param $expected
     * @param $version
     * @param $compare_version
     */
    public function testIsEqualsTo($expected, $version, $compare_version)
    {
        $main = new PloService_Version_Version($version);
        $this->assertSame($expected, $main->isEqualsTo(new PloService_Version_Version($compare_version)));
    }

    public function provideTestIsEqualsTo()
    {
        return [
            [false, "1.2.0", "1.1.0"],
            [false, "1.2.1", "1.2.0"],
            [true, "1.2.0", "1.2.0"],
            [false, "1.2.0", "1.3.0"],
            [false, "1.4.3", "1.4.4"],
            [false, "1.2.0", "1.1"],
            [false, "2.1.0", "2.0.9"],
            [true, "3.0.0", "3.0"],
            [true, "3.0", "3"],
            [false, "4.1", "4.2"],
            [false, "4.2.0", "4.3"]
        ];
    }


}
