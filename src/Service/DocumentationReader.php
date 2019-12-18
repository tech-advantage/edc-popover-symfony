<?php


namespace Techad\EdcPopoverBundle\Service;


use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Techad\EdcPopoverBundle\Model\Information;

class DocumentationReader
{
    private const MULTI_DOC_FILE = "multi-doc.json";
    private const INFO_FILE = "info.json";

    private $urlUtil;
    private $defaultLanguageCode;

    /**
     * DocumentationReader constructor.
     */
    public function __construct(UrlUtil $urlUtil, string $defaultLanguageCode)
    {
        $this->urlUtil = $urlUtil;
        $this->defaultLanguageCode = $defaultLanguageCode;
    }

    public function getInformations()
    {
        $informations = array();
        $publicationsIds = $this->readPublicationIds();
        foreach ($publicationsIds as $publicationId) {
            $informations[] = $this->readInfoFile($publicationId);
        }
        return $informations;
    }


    private function readPublicationIds()
    {
        $publicationIds = array();
        $multiDocUrl = $this->urlUtil->getRootDocumentationUrl(DocumentationReader::MULTI_DOC_FILE);
        $array = $this->get($multiDocUrl);
        foreach ($array as $docFile) {
            $publicationIds[] = $docFile['pluginId'];
        }
        return $publicationIds;
    }

    private function readInfoFile(string $publicationId) : Information
    {
        $url = $this->urlUtil->getRootDocumentationUrl($publicationId . "/" . DocumentationReader::INFO_FILE);
        $result = $this->get($url);
        $info = new Information();
        $defaultLanguage = $this->defaultLanguageCode;
        if (!empty($result['defaultLanguage'])) {
            $defaultLanguage = $result['defaultLanguage'];
        }
        $info->setDefaultLanguage($defaultLanguage);
        if (!empty($result['languages'])) {
            $info->addLanguages($result['languages']);
        }
        return $info;
    }

    private function get(string $url)
    {
        $json = array();
        $client = HttpClient::create();
        try {
            $response = $client->request('GET', $url);
            $json = $response->toArray(true);

        } catch (TransportExceptionInterface $e) {
            $json[] = $e->getMessage();
            $json[] = $url;
        } catch (ClientExceptionInterface $e) {
            $json[] = $e->getMessage();
            $json[] = $url;
        } catch (DecodingExceptionInterface $e) {
            $json[] = $e->getMessage();
            $json[] = $url;
        } catch (RedirectionExceptionInterface $e) {
            $json[] = $e->getMessage();
            $json[] = $url;
        } catch (ServerExceptionInterface $e) {
            $json[] = $e->getMessage();
            $json[] = $url;
        }
        return $json;
    }
}
