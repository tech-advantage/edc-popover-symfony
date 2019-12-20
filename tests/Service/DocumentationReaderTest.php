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
        $this->assertEquals(2, sizeof($contexts));
        $context = $contexts['fr.techad.edc.text_editor.en'];
        $this->assertEquals('Text Editor', $context->getLabel());
        $this->assertEquals(2, sizeof($context->getArticles()));
        $this->assertEquals(0, sizeof($context->getLinks()));
    }

    public function testShouldGetLabels()
    {
        $urlUtil = new UrlUtil(Constants::SERVER_URL, Constants::CONTEXT);
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil);
        $languages = ['en', 'fr'];
        $labels = $documentationReader->getLabels($languages);
        $this->assertEquals(2, sizeof($labels));
        $this->assertEquals(2, sizeof($labels['en']));
        $this->assertEquals(2, sizeof($labels['fr']));
        $this->assertEquals('Need more...', $labels['en']['articles']);
        $this->assertEquals('Related topics', $labels['en']['links']);
    }

    public function testShouldGetNoLabel()
    {
        $urlUtil = new UrlUtil(Constants::SERVER_URL, Constants::CONTEXT);
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil);
        $languages = ['cn', 'es'];
        $labels = $documentationReader->getLabels($languages);
        $this->assertEquals(0, sizeof($labels));
    }
}
