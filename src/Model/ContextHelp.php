<?php


namespace Techad\EdcPopoverBundle\Model;


class ContextHelp
{
    private $contextItem;
    private $labels;

    /**
     * @return ContextItem
     */
    public function getContextItem(): ?ContextItem
    {
        return $this->contextItem;
    }

    /**
     * @param ContextItem $contextItem
     */
    public function setContextItem(ContextItem $contextItem): void
    {
        $this->contextItem = $contextItem;
    }

    /**
     * @return array
     */
    public function getLabels(): array
    {
        return $this->labels;
    }

    /**
     * @param string $labels the labels to set
     */
    public function setLabels(array $labels): void
    {
        $this->labels = $labels;
    }


}
