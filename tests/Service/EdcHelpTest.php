<?php


namespace Techad\EdcPopoverBundle\Tests\Service;


use PHPUnit\Framework\TestCase;
use Techad\EdcPopoverBundle\Service\DocumentationReader;
use Techad\EdcPopoverBundle\Service\EdcHelp;
use Techad\EdcPopoverBundle\Service\KeyUtil;
use Techad\EdcPopoverBundle\Service\UrlUtil;

class EdcHelpTest extends TestCase
{
    public function testShouldGetContextItemWithForceLanguage()
    {
        $urlUtil = new UrlUtil("http://tech.easydoccontents.com", "help");
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil, 'en');
        $edcHelp = new EdcHelp($documentationReader, $keyUtil, 'en');
        $contextItem = $edcHelp->getContextItem("fr.techad.edc", "help.center", "en");
        $this->assertEquals('fr.techad.edc', $contextItem->getMainKey());
    }

    public function testShouldGetContextItemWithUnknownLanguage()
    {
        $urlUtil = new UrlUtil("http://tech.easydoccontents.com", "help");
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil, 'en');
        $edcHelp = new EdcHelp($documentationReader, $keyUtil, 'fr');
        $contextItem = $edcHelp->getContextItem("fr.techad.edc", "help.center", "en");
        $this->assertEquals('fr.techad.edc', $contextItem->getMainKey());
    }


    public function testShouldGetContextItemWithDefaultLanguage()
    {
        $urlUtil = new UrlUtil("http://tech.easydoccontents.com", "help");
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil, 'en');
        $edcHelp = new EdcHelp($documentationReader, $keyUtil, 'en');
        $contextItem = $edcHelp->getContextItem("fr.techad.edc", "help.center");
        $this->assertEquals('fr.techad.edc', $contextItem->getMainKey());
    }

    public function testShouldNoGetContextItemWithUnknownKeys()
    {
        $urlUtil = new UrlUtil("http://tech.easydoccontents.com", "help");
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil, 'en');
        $edcHelp = new EdcHelp($documentationReader, $keyUtil, 'en');
        $contextItem = $edcHelp->getContextItem("no.main.key", "help.center");
        $this->assertEquals(null, $contextItem);
    }

}
