<?php


namespace Techad\EdcPopoverBundle\Service;

use FlorianWolters\Component\Core\StringUtils;

class UrlUtil
{
    private $serverUrl;
    private $helpContext;

    /**
     * UrlUtil constructor.
     * @param string $serverUrl the server url
     * @param string $helpContext the help context
     */
    public function __construct(string $serverUrl, string $helpContext)
    {
        $this->serverUrl = $serverUrl;
        $this->helpContext = $helpContext;
    }


    /**
     * @param string $publicationId the publication identifier
     * @param string $mainKey the main key
     * @param string $subKey the secondary key
     * @param string $languageCode the language code
     * @param int $articleIndex the article index to display
     * @return string the url for a edc context
     */
    public function getContextUrl(string $publicationId, string $mainKey, string $subKey, string $languageCode, int $articleIndex)
    {
        return $this->getHelpServerUrl() . "/context/" . $publicationId . "/" . $mainKey . "/" . $subKey . "/" . $languageCode . "/" . $articleIndex;
    }

    /**
     * @param string $id the identifier of the document
     * @param string $languageCode the language code of the document
     * @param string $srcPublicationId the identifier of the publication
     * @return string the url for a edc document
     */
    public function getDocumentationUrl(string $id, string $languageCode = "", string $srcPublicationId = "")
    {
        $langCode = StringUtils::isNotBlank($languageCode) ? "/" . $languageCode : "";
        $publicationId = StringUtils::isNotBlank($srcPublicationId) ? $srcPublicationId . "/" : "";
        return $this->getHelpServerUrl() . "/doc/" . $publicationId . $id . $langCode;
    }

    public function getRootDocumentationUrl(string $file = "")
    {
        $f = StringUtils::isNotBlank($file) ? "/" . $file : "";
        return $this->serverUrl . "/doc" . $f;
    }

    /**
     * @return string the help server url
     */
    public function getHelpServerUrl()
    {
        return $this->serverUrl . "/" . $this->helpContext;
    }
}
