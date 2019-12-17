<?php

use PHPUnit\Framework\TestCase;
use Techad\EdcPopoverBundle\Service\UrlUtil;

class UrlUtilTest extends TestCase
{
    public function testShouldGetContextUrl()
    {
        $urlUtil = new UrlUtil("http://localhost", "help");
        $url = $urlUtil->getContextUrl("pId", "mk", "sk", "en", 0);
        $this->assertEquals("http://localhost/help/context/pId/mk/sk/en/0", $url);
    }

    public function testShouldGetDocumentationUrlForId() {
        $urlUtil = new UrlUtil("http://localhost", "help");
        $url = $urlUtil->getDocumentationUrl(1);
        $this->assertEquals("http://localhost/help/doc/1", $url);
    }

    public function testShouldGetDocumentationUrlForIdAndLanguageCode() {
        $urlUtil = new UrlUtil("http://localhost", "help");
        $url = $urlUtil->getDocumentationUrl(1, "en");
        $this->assertEquals("http://localhost/help/doc/1/en", $url);
    }

    public function testShouldGetDocumentationUrlForIdAndPublication() {
        $urlUtil = new UrlUtil("http://localhost", "help");
        $url = $urlUtil->getDocumentationUrl(1, "", "pId");
        $this->assertEquals("http://localhost/help/doc/pId/1", $url);
    }

    public function testShouldGetDocumentationUrlForIdAndLanguageCodedAndPublication() {
        $urlUtil = new UrlUtil("http://localhost", "help");
        $url = $urlUtil->getDocumentationUrl(1, "en", "pId");
        $this->assertEquals("http://localhost/help/doc/pId/1/en", $url);
    }
}
