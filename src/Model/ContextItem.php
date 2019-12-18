<?php


namespace Techad\EdcPopoverBundle\Model;


class ContextItem extends DocumentationItem
{
    private $description;
    private $mainKey;
    private $subKey;

    /**
     * ContextItem constructor.
     */
    public function __construct()
    {
        parent::__construct(DocumentationItemType::CONTEXTUAL);
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getMainKey()
    {
        return $this->mainKey;
    }

    /**
     * @param mixed $mainKey
     */
    public function setMainKey($mainKey): void
    {
        $this->mainKey = $mainKey;
    }

    /**
     * @return mixed
     */
    public function getSubKey()
    {
        return $this->subKey;
    }

    /**
     * @param mixed $subKey
     */
    public function setSubKey($subKey): void
    {
        $this->subKey = $subKey;
    }
}
