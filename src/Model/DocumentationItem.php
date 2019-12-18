<?php


namespace Techad\EdcPopoverBundle\Model;


use ArrayObject;

class DocumentationItem
{
    private $id;
    private $label;
    private $publicationId;
    private $url;
    private $languageCode;
    private $documentationItemType;
    private $articles;
    private $links;

    /**
     * DocumentationItem constructor.
     */
    public function __construct($type)
    {
        $this->articles = new ArrayObject();
        $this->links = new ArrayObject();
        $this->documentationItemType = $type;
    }

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed the label
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param the label to set
     */
    public function setLabel($label): void
    {
        $this->label = $label;
    }

    /**
     * @return the publication identifier
     */
    public function getPublicationId(): string
    {
        return $this->publicationId;
    }

    /**
     * @param the publication identifier
     */
    public function setPublicationId($publicationId): void
    {
        $this->publicationId = $publicationId;
    }

    /**
     * @return string the documentation url
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string the documentation url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }

    /**
     * @return string the language code
     */
    public function getLanguageCode(): string
    {
        return $this->languageCode;
    }

    /**
     * @param string $languageCode the language code
     */
    public function setLanguageCode($languageCode): void
    {
        $this->languageCode = $languageCode;
    }

    /**
     * @return mixed
     */
    public function getDocumentationItemType(): int
    {
        return $this->documentationItemType;
    }

    /**
     * @param mixed $documentationItemType
     */
    public function setDocumentationItemType($documentationItemType): void
    {
        $this->documentationItemType = $documentationItemType;
    }

    public function addArticle(DocumentationItem $article)
    {
        $this->articles->append($article);
    }

    public function addArticles(array $articles)
    {
        foreach ($articles as $article) {
            $this->articles->append($article);
        }
    }

    public function getArticles(): array
    {
        return $this->articles->getArrayCopy();
    }

    public function addLink(DocumentationItem $link)
    {
        $this->links->append($link);
    }

    public function addLinks(array $links)
    {
        foreach ($links as $link) {
            $this->links->append($link);
        }
    }

    public function getLinks(): array
    {
        return $this->links->getArrayCopy();
    }
}
