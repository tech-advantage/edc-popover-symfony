<?php


namespace Techad\EdcPopoverBundle\Service;

use FlorianWolters\Component\Core\StringUtils;

class UrlUtil
{
    /**
     * @param string $publicationId the publiblication identifier
     * @param string $mainKey the main key
     * @param string $subKey the secondary key
     * @param string $languageCode the language code
     * @param int $articleIndex the article index to display
     * @return string the url for a edc context
     */
    public function getContextUrl(string $publicationId, string $mainKey, string $subKey, string $languageCode, int $articleIndex)
    {
        return "/context/" . $publicationId . "/" . $mainKey . "/" . $subKey . "/" . $languageCode . "/" . $articleIndex;
    }

    /**
     * @param int $id the identifier of the document
     * @param string $languageCode the language code of the document
     * @param string $srcPublicationId the identifier of the publication
     * @return string the url for a edc document
     */
    public function getDocumentationUrl(int  $id, string $languageCode = "", string $srcPublicationId = "")
    {
        $langCode = StringUtils::isNotBlank($languageCode) ? "/" . $languageCode : "";
        $publicationId = StringUtils::isNotBlank($srcPublicationId) ? $srcPublicationId . "/" : "";
        return "/doc/" . $publicationId . $id . $langCode;
    }
}
