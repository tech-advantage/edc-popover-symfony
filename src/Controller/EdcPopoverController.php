<?php
/**
 * Created by IntelliJ IDEA.
 * User: vincke
 * Date: 20/12/2019
 * Time: 16:52
 */

namespace Techad\EdcPopoverBundle\Controller;

use Twig\Environment;

class EdcPopoverController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function renderMacro($mainKey, $subKey, $exportId)
    {
        return $this->twig->render('macroEdc.html.twig', ['mainKey' => $mainKey, '$subKey' => $subKey, '$exportId' => $exportId]);
    }
}