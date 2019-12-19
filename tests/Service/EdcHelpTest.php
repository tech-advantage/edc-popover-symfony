<?php


namespace Techad\EdcPopoverBundle\Tests\Service;


use PHPUnit\Framework\TestCase;
use Techad\EdcPopoverBundle\Service\DocumentationReader;
use Techad\EdcPopoverBundle\Service\EdcHelp;
use Techad\EdcPopoverBundle\Service\KeyUtil;
use Techad\EdcPopoverBundle\Service\UrlUtil;
use Techad\EdcPopoverBundle\Tests\Resources\Constants;

class EdcHelpTest extends TestCase
{
    public function testShouldGetContextItemWithForceLanguage()
    {
        $urlUtil = new UrlUtil(Constants::SERVER_URL, Constants::CONTEXT);
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil);
        $edcHelp = new EdcHelp($documentationReader, $keyUtil);
        $contextItem = $edcHelp->getContextItem("fr.techad.edc", "help.center", "en");
        $this->assertEquals('fr.techad.edc', $contextItem->getMainKey());
    }

    public function testShouldGetContextItemWithUnknownLanguage()
    {
        $urlUtil = new UrlUtil(Constants::SERVER_URL, Constants::CONTEXT);
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil);
        $edcHelp = new EdcHelp($documentationReader, $keyUtil);
        $contextItem = $edcHelp->getContextItem("fr.techad.edc", "help.center", "cn");
        $this->assertEquals('fr.techad.edc', $contextItem->getMainKey());
        $this->assertEquals('en', $contextItem->getLanguageCode());
    }


    public function testShouldGetContextItemWithDefaultLanguage()
    {
        $urlUtil = new UrlUtil(Constants::SERVER_URL, Constants::CONTEXT);
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil);
        $edcHelp = new EdcHelp($documentationReader, $keyUtil);
        $contextItem = $edcHelp->getContextItem("fr.techad.edc", "help.center");
        $this->assertEquals('fr.techad.edc', $contextItem->getMainKey());
        $this->assertEquals('en', $contextItem->getLanguageCode());
    }

    public function testShouldNoGetContextItemWithUnknownKeys()
    {
        $urlUtil = new UrlUtil(Constants::SERVER_URL, Constants::CONTEXT);
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil);
        $edcHelp = new EdcHelp($documentationReader, $keyUtil);
        $contextItem = $edcHelp->getContextItem("no.main.key", "help.center");
        $this->assertEquals(null, $contextItem);
    }

}
