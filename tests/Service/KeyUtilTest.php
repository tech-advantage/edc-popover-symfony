<?php


namespace Techad\EdcPopoverBundle\Tests\Service;


use PHPUnit\Framework\TestCase;
use Techad\EdcPopoverBundle\Service\KeyUtil;

class KeyUtilTest extends TestCase
{
    private const KEY = 'fr.techad.edc.en';

    public function testShouldConcatKeys()
    {
        $keyUtil = new KeyUtil();
        $key = $keyUtil->getKey('fr.techad', 'edc', 'en');
        $this->assertEquals(self::KEY, $key);
    }

    public function testShouldContainKey()
    {
        $keyUtil = new KeyUtil();
        $contain = $keyUtil->containsKey(self::KEY, 'fr.techad', 'edc');
        $this->assertEquals(true, $contain);
    }


    public function testShouldNotContainKeyWithBadMainKey()
    {
        $keyUtil = new KeyUtil();
        $contain = $keyUtil->containsKey(self::KEY, 'fr.techad.software', 'edc');
        $this->assertEquals(false, $contain);
    }

    public function testShouldNotContainKeyWithBadSubKey()
    {
        $keyUtil = new KeyUtil();
        $contain = $keyUtil->containsKey(self::KEY, 'fr.techad', 'feb');
        $this->assertEquals(false, $contain);
    }

    public function testShouldNotContainKeyWithEmptyFullKey()
    {
        $keyUtil = new KeyUtil();
        $contain = $keyUtil->containsKey('', 'fr.techad', 'feb');
        $this->assertEquals(false, $contain);
    }

    public function testShouldNotContainKeyWithEmptyMainKey()
    {
        $keyUtil = new KeyUtil();
        $contain = $keyUtil->containsKey(self::KEY, '', 'feb');
        $this->assertEquals(false, $contain);
    }

    public function testShouldNotContainKeyWithEmptySubKey()
    {
        $keyUtil = new KeyUtil();
        $contain = $keyUtil->containsKey(self::KEY, 'fr.techad', '');
        $this->assertEquals(false, $contain);
    }
}
