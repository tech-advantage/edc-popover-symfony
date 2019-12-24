<?php
/**
 * Created by IntelliJ IDEA.
 * User: vincke
 * Date: 20/12/2019
 * Time: 16:54
 */

namespace Techad\EdcPopoverBundle\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Techad\EdcPopoverBundle\Controller\EdcPopoverController;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class EdcPopoverControllerTest extends TestCase
{

    public function testRenderMacro()
    {
        $loader = new FilesystemLoader('template/');
        $twig = new Environment($loader);
        $controller = new EdcPopoverController($twig);

        $test = $controller->renderMacro('In the popover', 'subKey', 123);
        $this->assertContains('In the popover', $test);
    }
}
