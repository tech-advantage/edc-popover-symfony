<?php


namespace Techad\EdcPopoverBundle\Tests\Service;


use PHPUnit\Framework\TestCase;
use Techad\EdcPopoverBundle\Service\DocumentationReader;
use Techad\EdcPopoverBundle\Service\UrlUtil;

class DocumentationReaderTest extends TestCase
{
    public function testShouldGetInformations()
    {
        $urlUtil = new UrlUtil("http://tech.easydoccontents.com", "help");
        $documentationReader = new DocumentationReader($urlUtil, 'en');
        $infos = $documentationReader->getInformations();
        $this->assertEquals(1, sizeof($infos));
        $this->assertEquals('en', $infos[0]->getDefaultLanguage());
    }
}
