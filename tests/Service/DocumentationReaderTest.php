<?php


namespace Techad\EdcPopoverBundle\Tests\Service;


use PHPUnit\Framework\TestCase;
use Techad\EdcPopoverBundle\Service\DocumentationReader;
use Techad\EdcPopoverBundle\Service\KeyUtil;
use Techad\EdcPopoverBundle\Service\UrlUtil;
use Techad\EdcPopoverBundle\Tests\Resources\Constants;

class DocumentationReaderTest extends TestCase
{
    public function testShouldGetInformations()
    {
        $urlUtil = new UrlUtil(Constants::SERVER_URL, Constants::CONTEXT);
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil);
        $infos = $documentationReader->getInformations();
        $this->assertEquals(1, sizeof($infos));
        $this->assertEquals('en', $infos[0]->getDefaultLanguage());
    }

    public function testShouldGetContextContent()
    {
        $urlUtil = new UrlUtil(Constants::SERVER_URL, Constants::CONTEXT);
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil);
        $contexts = $documentationReader->getContexts();
        $this->assertEquals(38, sizeof($contexts));
        $context = $contexts['fr.techad.edc.help.center.en'];
        $this->assertEquals('About edc', $context->getLabel());
        $this->assertEquals(1, sizeof($context->getArticles()));
        $this->assertEquals(3, sizeof($context->getLinks()));
    }
}
