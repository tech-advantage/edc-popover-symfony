<?php


namespace Techad\EdcPopoverBundle\Service;


use FlorianWolters\Component\Core\StringUtils;
use Techad\EdcPopoverBundle\Model\ContextItem;

class EdcHelp
{
    /**
     * @var DocumentationReader $documentationReader
     */
    private $documentationReader;
    /**
     * @var KeyUtil $keyUtil
     */
    private $keyUtil;

    /**
     * EdcHelp constructor.
     */
    public function __construct(DocumentationReader $documentationReader, KeyUtil $keyUtil)
    {
        $this->documentationReader = $documentationReader;
        $this->keyUtil = $keyUtil;
    }

    public function getContextItem(string $mainKey, string $subKey, string $languageCode = ""): ?ContextItem
    {
        $infos = $this->documentationReader->getInformations();
        // We assume the default language is common to all info (edc rules)
        $defaultLanguageCode = $infos[0]->getDefaultLanguage();
        if (StringUtils::isBlank($languageCode)) {
            $languageCode = $defaultLanguageCode;
        }
        $contexts = $this->documentationReader->getContexts();
        $key = $this->keyUtil->getKey($mainKey, $subKey, $languageCode);
        $contextItem = null;
        // The context exists in the language code
        if (!empty($contexts[$key])) {
            $contextItem = $contexts[$key];
        } else {
            // No found in the language code, try with the default. This case is possible then the developper calls explicitly this method with an undefined language
            $key = $this->keyUtil->getKey($mainKey, $subKey, $defaultLanguageCode);
            if (!empty($contexts[$key])) {
                $contextItem = $contexts[$key];
            }
        }
        return $contextItem;
    }
}
