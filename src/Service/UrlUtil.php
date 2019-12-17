<?php


namespace Techad\EdcPopoverBundle\Service;

use FlorianWolters\Component\Core\StringUtils;

class UrlUtil
{
    private $serverUrl;
    private $helpContext;

    /**
     * UrlUtil constructor.
     * @param string $serverUrl the help server url
     * @param string $helpContext the help context
     */
    public function __construct(string $serverUrl, string $helpContext)
    {
        $this->serverUrl = $serverUrl;
        $this->helpContext = $helpContext;
    }


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
        return $this->serverUrl."/".$this->helpContext."/context/" . $publicationId . "/" . $mainKey . "/" . $subKey . "/" . $languageCode . "/" . $articleIndex;
    }

    /**
     * @param int $id the identifier of the document
     * @param string $languageCode the language code of the document
     * @param string $srcPublicationId the identifier of the publication
     * @return string the url for a edc document
     */
    public function getDocumentationUrl(int $id, string $languageCode = "", string $srcPublicationId = "")
    {
        $langCode = StringUtils::isNotBlank($languageCode) ? "/" . $languageCode : "";
        $publicationId = StringUtils::isNotBlank($srcPublicationId) ? $srcPublicationId . "/" : "";
        return $this->serverUrl."/".$this->helpContext."/doc/" . $publicationId . $id . $langCode;
    }
}
