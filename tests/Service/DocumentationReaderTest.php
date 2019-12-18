<?php


namespace Techad\EdcPopoverBundle\Tests\Service;


use PHPUnit\Framework\TestCase;
use Techad\EdcPopoverBundle\Service\DocumentationReader;
use Techad\EdcPopoverBundle\Service\KeyUtil;
use Techad\EdcPopoverBundle\Service\UrlUtil;

class DocumentationReaderTest extends TestCase
{
    public function testShouldGetInformations()
    {
        $urlUtil = new UrlUtil("http://tech.easydoccontents.com", "help");
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil, 'en');
        $infos = $documentationReader->getInformations();
        $this->assertEquals(1, sizeof($infos));
        $this->assertEquals('en', $infos[0]->getDefaultLanguage());
    }

    public function testShouldGetContextContent()
    {
        $urlUtil = new UrlUtil("http://tech.easydoccontents.com", "help");
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil, 'en');
        $contexts = $documentationReader->getContexts();
        $this->assertEquals(38, sizeof($contexts));
        $context = $contexts['fr.techad.edc.help.center.en'];
        $this->assertEquals('About edc', $context->getLabel());
        $this->assertEquals(1, sizeof($context->getArticles()));
        $this->assertEquals(3, sizeof($context->getLinks()));
    }
}
