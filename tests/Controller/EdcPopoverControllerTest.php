<?php
/**
 * Created by IntelliJ IDEA.
 * User: vincke
 * Date: 20/12/2019
 * Time: 16:54
 */

namespace Techad\EdcPopoverBundle\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Techad\EdcPopoverBundle\Model\ContextHelp;
use Techad\EdcPopoverBundle\Service\DocumentationReader;
use Techad\EdcPopoverBundle\Service\EdcHelp;
use Techad\EdcPopoverBundle\Service\KeyUtil;
use Techad\EdcPopoverBundle\Service\UrlUtil;
use Techad\EdcPopoverBundle\Tests\Controller\EdcPopoverController;
use Techad\EdcPopoverBundle\Tests\Resources\Constants;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;


class EdcPopoverControllerTest extends TestCase
{
    private const MAIN_KEY = 'fr.techad.edc';
    private const SUB_KEY = 'documentation_type';

    public function etestRenderMacroWithDefaultConfiguration()
    {
        $contextHelp = $this->getContextHelp(EdcPopoverControllerTest::MAIN_KEY, EdcPopoverControllerTest::SUB_KEY);

        $content = $this->renderMacro($contextHelp, []);
        // Title
        $this->assertStringContainsString('Documentation Types', $content);
        // script to check the javascript was generated
        $this->assertStringContainsString('<script>', $content);
        // Check if the div for description is rendered
        $this->assertStringContainsString("<div class='edc-desc'>", $content);
    }

    public function testRenderMacroWithNoSummary()
    {
        $contextHelp = $this->getContextHelp(EdcPopoverControllerTest::MAIN_KEY, EdcPopoverControllerTest::SUB_KEY);

        $content = $this->renderMacro($contextHelp, ['summary' => false]);
        // Just a link to the first article
        $this->assertStringContainsString('<a href=\'http://localhost:8888/help/context/edc/fr.techad.edc/documentation_type/en/0\'', $content);
        // The popover is not defined so:
        // Title is not defined
        $this->assertStringNotContainsString('Documentation Types', $content);
        // the javascript wasn't generated
        $this->assertStringNotContainsString('<script>', $content);
        // the div for description isn't rendered
        $this->assertStringNotContainsString("<div class='edc-desc'>", $content);
    }


    public function etestRenderMacroWithNoContentItem()
    {
        $contextHelp = $this->getContextHelp(EdcPopoverControllerTest::MAIN_KEY, 'fr');

        $content = $this->renderMacro($contextHelp, []);
        // Title
        $this->assertStringContainsString('No defined', $content);
        // script to check the javascript was generated
        $this->assertStringContainsString('<script>', $content);
        // Check if the div for description is missing
        $this->assertStringNotContainsString("<div class='edc-desc'>", $content);
    }

    private function renderMacro(ContextHelp $contentHelp, $globals)
    {
        $twig = $this->getTwig();
        if (sizeof($globals) > 0) {
            $twig->addGlobal('popover', $globals);
        }
        try {
            $content = $twig->render('edc-test.html.twig', ['contentHelp' => $contentHelp]);
        } catch (LoaderError $e) {
            var_dump($e->getRawMessage());
        } catch (RuntimeError $e) {
            var_dump('RT');
        } catch (SyntaxError $e) {
            var_dump('SE');
        }
        return $content;
    }

    private function getContextHelp($mainKey, $subKey)
    {
        $urlUtil = new UrlUtil(Constants::SERVER_URL, Constants::CONTEXT);
        $keyUtil = new KeyUtil();
        $documentationReader = new DocumentationReader($urlUtil, $keyUtil);
        $edcHelp = new EdcHelp($documentationReader, $keyUtil);
        return $edcHelp->getContextHelp($mainKey, $subKey);
    }

    private function getTwig()
    {
        $loader = new FilesystemLoader(['src/Resources/views', 'tests/views']);
        return new Environment($loader);
    }
}
