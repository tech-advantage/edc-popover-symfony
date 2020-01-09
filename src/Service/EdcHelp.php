<?php


namespace Techad\EdcPopoverBundle\Service;


use FlorianWolters\Component\Core\StringUtils;
use Techad\EdcPopoverBundle\Model\ContextHelp;
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
     * @param DocumentationReader $documentationReader the documentation reader
     * @param KeyUtil $keyUtil the key utility
     */
    public function __construct(DocumentationReader $documentationReader, KeyUtil $keyUtil)
    {
        $this->documentationReader = $documentationReader;
        $this->keyUtil = $keyUtil;
    }

    public function getContextHelp(string $mainKey, string $subKey, string $languageCode = ""): ?ContextHelp
    {
        $contextHelp = new ContextHelp();
        $contextItem = $this->getContextItem($mainKey, $subKey, $languageCode);
        if ($contextItem != null) {
            $contextHelp->setContextItem($contextItem);
        }
        $contextHelp->setLabels($this->getLabelsFromLanguage($languageCode));
        return $contextHelp;
    }

    public function getContextItem(string $mainKey, string $subKey, string $languageCode = ""): ?ContextItem
    {
        $infos = $this->getInformations();
        $defaultLanguageCode = $this->getDefaultLanguage($infos);
        $languageCode = $this->getLanguage($languageCode, $infos);
        $contexts = $this->getContexts();
        $key = $this->keyUtil->getKey($mainKey, $subKey, $languageCode);
        $contextItem = null;

        // The context exists in the language code
        if (!empty($contexts[$key])) {
            $contextItem = $contexts[$key];
        } else {
            // No found in the language code, try with the default. This case is possible then the developer calls explicitly this method with an undefined language
            $key = $this->keyUtil->getKey($mainKey, $subKey, $defaultLanguageCode);
            if (!empty($contexts[$key])) {
                $contextItem = $contexts[$key];
            }
        }
        return $contextItem;
    }

    public function getLabel(string $labelKey, string $languageCode = ""): string
    {
        $infos = $this->getInformations();
        $defaultLanguageCode = $this->getDefaultLanguage($infos);
        $languageCode = $this->getLanguage($languageCode, $infos);
        $labels = $this->getLabels($infos);
        // The label exists in the language code
        $label = $this->getLabelFromLanguage($labels, $labelKey, $languageCode);
        // No found in the language code, try with the default. This case is possible then the developer calls explicitly this method with an undefined language
        if (StringUtils::isBlank($label)) {
            $label = $this->getLabelFromLanguage($labels, $labelKey, $defaultLanguageCode);
        }
        return $label;
    }

    private function getInformations()
    {
        return $this->documentationReader->getInformations();
    }

    private function getDefaultLanguage(array $infos): string
    {
        // We assume the default language is common to all info (edc rules)
        return $infos[0]->getDefaultLanguage();
    }

    private function getLanguage(string $languageCode, array $infos): string
    {
        // We assume the default language is common to all info (edc rules)
        $info = $infos[0];
        $language = $languageCode;
        if (StringUtils::isBlank($languageCode)) {
            $language = $info->getDefaultLanguage();
        }
        if (!in_array($languageCode, $info->getLanguages())) {
            $language = $info->getDefaultLanguage();
        }
        return $language;
    }

    private function getContexts()
    {
        return $this->documentationReader->getContexts();
    }

    private function getLabelsFromLanguage(string $languageCode): array
    {
        $infos = $this->getInformations();
        $defaultLanguageCode = $this->getDefaultLanguage($infos);
        $labels = $this->getLabels($infos);
        $result = array();
        if (!empty($labels[$languageCode])) {
            $result = $labels[$languageCode];
        } else if (!empty($labels[$defaultLanguageCode])) {
            $result = $labels[$defaultLanguageCode];
        }

        return $result;
    }

    private function getLabels(array $infos)
    {
        $languages = array();
        // Merge all languages declared in infos
        foreach ($infos as $info) {
            $languages = array_merge($languages, $info->getLanguages());
        }
        // remove duplicate language
        $languages = array_unique($languages);
        return $this->documentationReader->getLabels($languages);
    }

    private function getLabelFromLanguage(array $labels, string $labelKey, string $languageCode)
    {
        $label = '';
        if (!empty($labels[$languageCode]) && !empty($labels[$languageCode][$labelKey])) {
            $label = $labels[$languageCode][$labelKey];
        }
        return $label;
    }

}
