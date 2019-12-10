<?php


namespace Techad\EdcPopoverBundle;


use Symfony\Component\HttpKernel\Bundle\Bundle;
use Techad\EdcPopoverBundle\DependencyInjection\EdcPopoverExtension;

class EdcPopoverBundle extends Bundle
{

    /**
     * Overridden to allow for the custom extension alias.
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EdcPopoverExtension();
        }
        return $this->extension;
    }
}
