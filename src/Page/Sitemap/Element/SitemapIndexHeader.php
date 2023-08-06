<?php

namespace Macareux\MultisiteSitemap\Page\Sitemap\Element;

use Concrete\Core\Error\UserMessageException;
use Concrete\Core\Page\Sitemap\Element\SitemapElement;
use SimpleXMLElement;

class SitemapIndexHeader extends SitemapElement
{
    public function toXmlLines($indenter = '  '): array
    {
        return [
            $this->getXmlMetaHeader(),
            $this->getSitemapIndex(false),
        ];
    }

    /**
     * @throws UserMessageException
     */
    public function toXmlElement(SimpleXMLElement $parentElement = null): SimpleXMLElement
    {
        if ($parentElement !== null) {
            throw new UserMessageException(t('The sitemap XML header should be the first element.'));
        }

        return new SimpleXMLElement($this->getXmlMetaHeader() . $this->getSitemapIndex(true));
    }

    /**
     * @param bool $selfClosing
     *
     * @return string
     */
    protected function getSitemapIndex($selfClosing): string
    {
        return '<sitemapindex xmlns="' . static::DEFAULT_NAMESPACE . '"' . ($selfClosing ? '/>' : '>');
    }
}