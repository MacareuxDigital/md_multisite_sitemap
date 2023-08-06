<?php

namespace Macareux\MultisiteSitemap\Page\Sitemap\Element;

use Concrete\Core\Entity\Site\Site;
use Concrete\Core\Error\UserMessageException;
use Concrete\Core\Page\Sitemap\Element\SitemapElement;
use Concrete\Core\Url\Resolver\Manager\ResolverManagerInterface;
use SimpleXMLElement;

class SitemapSite extends SitemapElement
{
    protected Site $site;
    protected ResolverManagerInterface $resolver;

    /**
     * @param Site $site
     */
    public function __construct(Site $site, ResolverManagerInterface $resolver)
    {
        $this->site = $site;
        $this->resolver = $resolver;
    }

    public function toXmlLines($indenter = '  '): array
    {
        $loc = $this->getLocation();
        if ($indenter) {
            $prefix = $indenter;
            $prefix2 = $indenter . $indenter;
        } else {
            $prefix = '';
            $prefix2 = '';
        }

        return [
            "{$prefix}<sitemap>",
            "{$prefix2}<loc>{$loc}</loc>",
            "{$prefix}</sitemap>"
        ];
    }

    public function toXmlElement(SimpleXMLElement $parentElement = null)
    {
        if ($parentElement === null) {
            throw new UserMessageException(t('The sitemap XML page should not be the first element.'));
        }

        $result = $parentElement->addChild('sitemap');
        $result->addChild('loc', $this->getLocation());

        return $result;
    }

    protected function getLocation(): string
    {
        return (string) $this->resolver->resolve(['sitemap_' . $this->site->getSiteID() . '.xml']);
    }
}