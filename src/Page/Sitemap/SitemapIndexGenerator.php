<?php

namespace Macareux\MultisiteSitemap\Page\Sitemap;

use Concrete\Core\Cache\Cache;
use Concrete\Core\Page\Sitemap\SitemapGenerator;
use Concrete\Core\Site\Service;
use Concrete\Core\Support\Facade\Application;
use Macareux\MultisiteSitemap\Page\Sitemap\Element\SitemapIndexFooter;
use Macareux\MultisiteSitemap\Page\Sitemap\Element\SitemapIndexHeader;
use Macareux\MultisiteSitemap\Page\Sitemap\Element\SitemapSite;

class SitemapIndexGenerator extends SitemapGenerator
{
    public function generateContents(): \Generator
    {
        $app = Application::getFacadeApplication();
        /** @var Service $service */
        $service = $app->make('site');
        $sites = $service->getList();
        try {
            yield $app->make(SitemapIndexHeader::class);
            foreach ($sites as $site) {
                yield $app->make(SitemapSite::class, ['site' => $site]);
            }
            yield $app->make(SitemapIndexFooter::class);
            Cache::disableAll();
        } finally {
            Cache::enableAll();
        }
    }
}