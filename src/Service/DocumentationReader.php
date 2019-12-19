<?php


namespace Techad\EdcPopoverBundle\Service;


use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Techad\EdcPopoverBundle\Model\ContextItem;
use Techad\EdcPopoverBundle\Model\DocumentationItem;
use Techad\EdcPopoverBundle\Model\DocumentationItemType;
use Techad\EdcPopoverBundle\Model\Information;

class DocumentationReader
{
    private const MULTI_DOC_FILE = "multi-doc.json";
    private const CONTEXT_FILE = "context.json";
    private const INFO_FILE = "info.json";

    private $urlUtil;
    private $keyUtil;

    /**
     * DocumentationReader constructor.
     */
    public function __construct(UrlUtil $urlUtil, KeyUtil $keyUtil)
    {
        $this->urlUtil = $urlUtil;
        $this->keyUtil = $keyUtil;
    }

    /**
     * @return array of informations
     */
    public function getInformations()
    {
        $informations = array();
        $publicationsIds = $this->readPublicationIds();
        foreach ($publicationsIds as $publicationId) {
            $informations[] = $this->readInfoFile($publicationId);
        }
        return $informations;
    }

    /**
     *
     */
    public function getContexts()
    {
        $contexts = array();
        $publicationsIds = $this->readPublicationIds();
        foreach ($publicationsIds as $publicationId) {
            $this->readContext($contexts, $publicationId);
        }
        return $contexts;
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

    private function readInfoFile(string $publicationId): Information
    {
        $url = $this->urlUtil->getRootDocumentationUrl($publicationId . "/" . DocumentationReader::INFO_FILE);
        $result = $this->get($url);
        $info = new Information();
        $defaultLanguage = $result['defaultLanguage'];
        $info->setDefaultLanguage($defaultLanguage);
        if (!empty($result['languages'])) {
            $info->addLanguages($result['languages']);
        }
        return $info;
    }

    private function readContext(array &$contexts, string $publicationId)
    {
        $url = $this->urlUtil->getRootDocumentationUrl($publicationId . "/" . DocumentationReader::CONTEXT_FILE);
        $result = $this->get($url);
        $mainKeys = array_keys($result);
        foreach ($mainKeys as $mainKey) {
            $this->parseContextSubKey($contexts, $publicationId, $mainKey, $result[$mainKey]);
        }
    }

    private function parseContextSubKey(array &$contexts, string $publicationId, string $mainKey, array $mainKeyNode)
    {
        $subKeys = array_keys($mainKeyNode);
        foreach ($subKeys as $subKey) {
            $this->parseContextLanguage($contexts, $publicationId, $mainKey, $subKey, $mainKeyNode[$subKey]);
        }
    }

    private function parseContextLanguage(array &$contexts, string $publicationId, string $mainKey, string $subKey, array $subKeyNode)
    {
        $languages = array_keys($subKeyNode);
        foreach ($languages as $language) {
            $context = $this->createContextItem($publicationId, $mainKey, $subKey, $language, $subKeyNode[$language]);
            $contexts[$this->keyUtil->getKey($context->getMainKey(), $context->getSubKey(), $context->getLanguageCode())] = $context;
        }
    }

    private function createContextItem(string $publicationId, string $mainKey, string $subKey, string $language, array $contextArray): ContextItem
    {
        $contextItem = new ContextItem();
        $contextItem->setMainKey($mainKey);
        $contextItem->setSubKey($subKey);
        $contextItem->setLanguageCode($language);
        $contextItem->setDescription($contextArray['description']);
        $contextItem->setLabel($contextArray['label']);
        $contextItem->setUrl($contextArray['url']);
        $contextItem->setPublicationId($publicationId);
        $contextItem->addArticles($this->createArticles($publicationId, $language, $contextArray['articles']));
        $contextItem->addLinks($this->createLinks($publicationId, $language, $contextArray['links']));
        return $contextItem;
    }

    private function createArticles(string $publicationId, string $language, array $articleArray)
    {
        $articles = array();
        foreach ($articleArray as $item) {
            $article = new DocumentationItem(DocumentationItemType::ARTICLE);
            $article->setId($item['id']);
            $article->setLabel($item['label']);
            $article->setUrl($item['url']);
            $article->setPublicationId($publicationId);
            $article->setLanguageCode($language);
            $articles[] = $article;
        }
        return $articles;
    }

    private function createLinks(string $publicationId, string $language, array $linkArray)
    {
        $links = array();
        foreach ($linkArray as $item) {
            $type = $item['type'] == 'DOCUMENT' ? DocumentationItemType::DOCUMENT : DocumentationItemType::CHAPTER;
            $link = new DocumentationItem($type);
            $link->setId($item['id']);
            $link->setLabel($item['label']);
            $link->setUrl($item['url']);
            $link->setPublicationId($publicationId);
            $link->setLanguageCode($language);
            $links[] = $link;
        }
        return $links;
    }

    private function get(string $url)
    {
        $array = array();
        $client = HttpClient::create();
        try {
            $response = $client->request('GET', $url);
            $array = $response->toArray(true);

        } catch (TransportExceptionInterface $e) {
            $array[] = $e->getMessage();
            $array[] = $url;
        } catch (ClientExceptionInterface $e) {
            $array[] = $e->getMessage();
            $array[] = $url;
        } catch (DecodingExceptionInterface $e) {
            $array[] = $e->getMessage();
            $array[] = $url;
        } catch (RedirectionExceptionInterface $e) {
            $array[] = $e->getMessage();
            $array[] = $url;
        } catch (ServerExceptionInterface $e) {
            $array[] = $e->getMessage();
            $array[] = $url;
        }
        return $array;
    }
}
