<?php


namespace Techad\EdcPopoverBundle\Model;


class Information
{
    private $defaultLanguage;
    private $languages;

    /**
     * Information constructor.
     */
    public function __construct()
    {
        $this->languages = new \ArrayObject();
    }


    /**
     * @return string the default language
     */
    public function getDefaultLanguage(): string
    {
        return $this->defaultLanguage;
    }

    /**
     * @param mixed $defaultLanguage
     */
    public function setDefaultLanguage($defaultLanguage): void
    {
        $this->defaultLanguage = $defaultLanguage;
    }

    /**
     * @return array
     */
    public function getLanguages(): array
    {
        return $this->languages->getArrayCopy();
    }

    /**
     * @param array $languages
     */
    public function addLanguages(array $languages): void
    {
        foreach ($languages as $language)
            $this->languages->append($language);
    }


}
