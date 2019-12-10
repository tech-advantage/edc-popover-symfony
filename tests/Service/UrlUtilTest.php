<?php

use PHPUnit\Framework\TestCase;
use Techad\EdcPopoverBundle\Service\UrlUtil;

class UrlUtilTest extends TestCase
{
    public function testShouldGetContextUrl()
    {
        $urlUtil = new UrlUtil();
        $url = $urlUtil->getContextUrl("pId", "mk", "sk", "en", 0);
        $this->assertEquals("/context/pId/mk/sk/en/0", $url);
    }

    public function testShouldGetDocumentationUrlForId() {
        $urlUtil = new UrlUtil();
        $url = $urlUtil->getDocumentationUrl(1);
        $this->assertEquals("/doc/1", $url);
    }

    public function testShouldGetDocumentationUrlForIdAndLanguageCode() {
        $urlUtil = new UrlUtil();
        $url = $urlUtil->getDocumentationUrl(1, "en");
        $this->assertEquals("/doc/1/en", $url);
    }

    public function testShouldGetDocumentationUrlForIdAndPublication() {
        $urlUtil = new UrlUtil();
        $url = $urlUtil->getDocumentationUrl(1, "", "pId");
        $this->assertEquals("/doc/pId/1", $url);
    }

    public function testShouldGetDocumentationUrlForIdAndLanguageCodedAndPublication() {
        $urlUtil = new UrlUtil();
        $url = $urlUtil->getDocumentationUrl(1, "en", "pId");
        $this->assertEquals("/doc/pId/1/en", $url);
    }
}
