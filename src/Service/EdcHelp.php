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
     * @var string $defaultLanguageCode
     */
    private $defaultLanguageCode;

    /**
     * EdcHelp constructor.
     */
    public function __construct(DocumentationReader $documentationReader, KeyUtil $keyUtil, string $defaultLanguageCode)
    {
        $this->documentationReader = $documentationReader;
        $this->keyUtil = $keyUtil;
        $this->defaultLanguageCode = $defaultLanguageCode;
    }

    public function getContextItem(string $mainKey, string $subKey, string $languageCode = ""): ?ContextItem
    {
        if (StringUtils::isBlank($languageCode)) {
            $languageCode = $this->defaultLanguageCode;
        }
        $contexts = $this->documentationReader->getContexts();
        $key = $this->keyUtil->getKey($mainKey, $subKey, $languageCode);
        $contextItem = null;
        if (!empty($contexts[$key])) {
            $contextItem = $contexts[$key];
        }
        else {
            $key = $this->keyUtil->getKey($mainKey, $subKey, $this->defaultLanguageCode);
            if (!empty($contexts[$key])) {
                $contextItem = $contexts[$key];
            }
        }
        return $contextItem;
    }
}
