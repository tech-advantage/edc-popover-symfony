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
    private const MAIN_KEY = 'fr.techad.edc';
    private const SUB_KEY = 'documentation_type';


    public function testShouldGetContextHelpWithEnglishLanguage()
    {
        $urlUtil = new UrlUtil(Constants::SERVER_URL, Constants::CONTEXT);
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil);
        $edcHelp = new EdcHelp($documentationReader, $keyUtil);
        $contextHelp = $edcHelp->getContextHelp(EdcHelpTest::MAIN_KEY, EdcHelpTest::SUB_KEY, "en");
        $contextItem = $contextHelp->getContextItem();
        $this->assertEquals('en', $contextItem->getLanguageCode());
        $this->assertEquals('fr.techad.edc', $contextItem->getMainKey());
        $this->assertEquals('Need more...', $contextHelp->getLabels()['articles']);
    }

    public function testShouldGetContextHelpWithFrenchLanguage()
    {
        $urlUtil = new UrlUtil(Constants::SERVER_URL, Constants::CONTEXT);
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil);
        $edcHelp = new EdcHelp($documentationReader, $keyUtil);
        $contextHelp = $edcHelp->getContextHelp(EdcHelpTest::MAIN_KEY, EdcHelpTest::SUB_KEY, "fr");
        $contextItem = $contextHelp->getContextItem();
        $this->assertEquals('fr', $contextItem->getLanguageCode());
        $this->assertEquals('fr.techad.edc', $contextItem->getMainKey());
        $this->assertEquals('Plus d\'info...', $contextHelp->getLabels()['articles']);
    }

    public function testShouldGetContextHelpWithUnknownLanguage()
    {
        $urlUtil = new UrlUtil(Constants::SERVER_URL, Constants::CONTEXT);
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil);
        $edcHelp = new EdcHelp($documentationReader, $keyUtil);
        $contextHelp = $edcHelp->getContextHelp(EdcHelpTest::MAIN_KEY, EdcHelpTest::SUB_KEY, "cn");
        $contextItem = $contextHelp->getContextItem();
        $this->assertEquals('en', $contextItem->getLanguageCode());
        $this->assertEquals('fr.techad.edc', $contextItem->getMainKey());
        $this->assertEquals('Need more...', $contextHelp->getLabels()['articles']);
    }

    public function testShouldGetContextHelpWithDefaultLanguage()
    {
        $urlUtil = new UrlUtil(Constants::SERVER_URL, Constants::CONTEXT);
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil);
        $edcHelp = new EdcHelp($documentationReader, $keyUtil);
        $contextHelp = $edcHelp->getContextHelp(EdcHelpTest::MAIN_KEY, EdcHelpTest::SUB_KEY);
        $contextItem = $contextHelp->getContextItem();
        $this->assertEquals('fr.techad.edc', $contextItem->getMainKey());
        $this->assertEquals('en', $contextItem->getLanguageCode());
        $this->assertEquals('Need more...', $contextHelp->getLabels()['articles']);
    }

    public function testShouldGetContextItemWithDefinedLanguage()
    {
        $urlUtil = new UrlUtil(Constants::SERVER_URL, Constants::CONTEXT);
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil);
        $edcHelp = new EdcHelp($documentationReader, $keyUtil);
        $contextItem = $edcHelp->getContextItem(EdcHelpTest::MAIN_KEY, EdcHelpTest::SUB_KEY, "en");
        $this->assertEquals('fr.techad.edc', $contextItem->getMainKey());
    }

    public function testShouldGetContextItemWithUnknownLanguage()
    {
        $urlUtil = new UrlUtil(Constants::SERVER_URL, Constants::CONTEXT);
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil);
        $edcHelp = new EdcHelp($documentationReader, $keyUtil);
        $contextItem = $edcHelp->getContextItem(EdcHelpTest::MAIN_KEY, EdcHelpTest::SUB_KEY, "cn");
        $this->assertEquals('fr.techad.edc', $contextItem->getMainKey());
        $this->assertEquals('en', $contextItem->getLanguageCode());
    }


    public function testShouldGetContextItemWithDefaultLanguage()
    {
        $urlUtil = new UrlUtil(Constants::SERVER_URL, Constants::CONTEXT);
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil);
        $edcHelp = new EdcHelp($documentationReader, $keyUtil);
        $contextItem = $edcHelp->getContextItem(EdcHelpTest::MAIN_KEY, EdcHelpTest::SUB_KEY);
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

    public function testShouldGetLabel()
    {
        $urlUtil = new UrlUtil(Constants::SERVER_URL, Constants::CONTEXT);
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil);
        $edcHelp = new EdcHelp($documentationReader, $keyUtil);
        $label = $edcHelp->getLabel('articles', 'en');
        $this->assertEquals('Need more...', $label);
    }

    public function testShouldGetDefaultLabelWithUndefinedLanguage()
    {
        $urlUtil = new UrlUtil(Constants::SERVER_URL, Constants::CONTEXT);
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil);
        $edcHelp = new EdcHelp($documentationReader, $keyUtil);
        $label = $edcHelp->getLabel('articles', 'cn');
        $this->assertEquals('Need more...', $label);
    }

    public function testShouldGetLabelWithUndefinedKey()
    {
        $urlUtil = new UrlUtil(Constants::SERVER_URL, Constants::CONTEXT);
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil);
        $edcHelp = new EdcHelp($documentationReader, $keyUtil);
        $label = $edcHelp->getLabel('edc', 'cn');
        $this->assertEquals('', $label);
    }
}
