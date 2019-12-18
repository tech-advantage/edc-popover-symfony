<?php


namespace Techad\EdcPopoverBundle\Service;


use FlorianWolters\Component\Core\StringUtils;

class KeyUtil
{
    /**
     * @param string $mainKey
     * @param string $subKey
     * @param string $languageCode
     * @return string the full key
     */
    public function getKey(string $mainKey, string $subKey, string $languageCode): string
    {
        return $mainKey . "." . $subKey . "." . $languageCode;
    }

    /**
     * @param string $fullKey the chain in which we have to search.
     * @param string $mainKey the main key to search
     * @param string $subKey the sub key to search
     * @return bool return true if the main and sub keys are contained in the full key.
     */
    public function containsKey(string $fullKey, string $mainKey, string $subKey): bool
    {
        $result = StringUtils::isNotBlank($fullKey) && StringUtils::isNotBlank($mainKey) && StringUtils::isNotBlank($subKey);
        if ($result) {
            $pos = strpos($fullKey, $mainKey . "." . $subKey);
            if ($pos === false) {
                $result = false;
            }
        }
        return $result;
    }
}
