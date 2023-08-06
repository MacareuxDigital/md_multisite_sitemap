<?php

namespace Macareux\MultisiteSitemap\Page\Sitemap\Element;

use Concrete\Core\Page\Sitemap\Element\SitemapElement;
use SimpleXMLElement;

class SitemapIndexFooter extends SitemapElement
{
    public function toXmlLines($indenter = '  '): array
    {
        return ['</sitemapindex>'];
    }

    public function toXmlElement(SimpleXMLElement $parentElement = null)
    {
    }
}
