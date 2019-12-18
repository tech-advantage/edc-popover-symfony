<?php


namespace Techad\EdcPopoverBundle\Model;


/**
 * Class DocumentationItemType
 *
 * @method static DocumentationItemType CONTEXTUAL()
 */
class DocumentationItemType
{
    /**
     * Unknown documentation item type
     */
    const UNKNOWN = 0;
    /**
     * Chapter documentation type. This is a documentation item which can contain DOCUMENT and CONTEXTUEL documentation item.
     */
    const CHAPTER = 1;
    /**
     * Contextual documentation item type ie bricks. It can contain ARTICLE documentation type
     */
    const CONTEXTUAL = 2;
    /**
     * Document documentation item type.It can contain ARTICLE documentation type
     */
    const DOCUMENT = 3;
    /**
     * Article documentation item type. it can't contain anything.
     */
    const ARTICLE = 4;
}
