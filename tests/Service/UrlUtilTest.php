<?php

use PHPUnit\Framework\TestCase;
use Techad\EdcPopoverBundle\Service\UrlUtil;

class UrlUtilTest extends TestCase
{
    public function test()
    {
        $urlUtl = new UrlUtil();
        $url = $urlUtl->getContextUrl("pId", "mk", "sk", "en", 0);
        $this->assertEquals("/context/pId/mk/sk/en/0", $url);
    }
}
