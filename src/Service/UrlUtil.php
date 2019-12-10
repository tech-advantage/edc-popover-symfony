<?php


namespace Techad\EdcPopoverBundle\Service;


class UrlUtil
{
    /**
     * @param string $publicationId the publiblication identifier
     * @param string $mainKey the main key
     * @param string $subKey the secondary key
     * @param string $languageCode the language code
     * @param int $articleIndex the article index to display
     * @return string the url for a context
     */
    public function getContextUrl(string $publicationId, string $mainKey, string $subKey, string $languageCode, int $articleIndex)
    {
        return "/context/" . $publicationId . "/" . $mainKey . "/" . $subKey . "/" . $languageCode . "/" . $articleIndex;
    }
}
