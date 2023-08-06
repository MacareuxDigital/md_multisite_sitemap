<?php

namespace Macareux\MultisiteSitemap\Page\Sitemap\Command;

use Concrete\Core\Command\Task\Output\OutputAwareInterface;
use Concrete\Core\Command\Task\Output\OutputAwareTrait;
use Concrete\Core\Page\Sitemap\PageListGenerator;
use Concrete\Core\Page\Sitemap\SitemapGenerator;
use Concrete\Core\Page\Sitemap\SitemapWriter;
use Concrete\Core\Site\Service;
use Concrete\Core\Support\Facade\Application;

class GenerateMultisiteSitemapCommandHandler implements OutputAwareInterface
{
    use OutputAwareTrait;

    public function __invoke(GenerateMultisiteSitemapCommand $command): void
    {
        $app = Application::getFacadeApplication();

        /** @var Service $service */
        $service = $app->make('site');
        $siteID = $command->getSiteID();
        if ($siteID) {
            $site = $service->getByID($siteID);
            if ($site) {
                /** @var PageListGenerator $pageListGenerator */
                $pageListGenerator = $app->make(PageListGenerator::class);
                $pageListGenerator->setSite($site);
                /** @var SitemapGenerator $sitemapGenerator */
                $sitemapGenerator = $app->make(SitemapGenerator::class);
                $sitemapGenerator->setPageListGenerator($pageListGenerator);
                /** @var SitemapWriter $writer */
                $writer = $app->make(SitemapWriter::class);
                $writer->setOutputFilename('sitemap_' . $siteID . '.xml');
                $writer->setSitemapGenerator($sitemapGenerator);
                $writer->generate();
                $sitemapUrl = $writer->getSitemapUrl();
                $this->output->write(t('Sitemap URL available at: %s', $sitemapUrl));
            }
        }
    }
}