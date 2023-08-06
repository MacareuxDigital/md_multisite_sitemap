<?php

namespace Macareux\MultisiteSitemap\Page\Sitemap\Command;

use Concrete\Core\Command\Task\Output\OutputAwareInterface;
use Concrete\Core\Command\Task\Output\OutputAwareTrait;
use Concrete\Core\Page\Sitemap\PageListGenerator;
use Concrete\Core\Page\Sitemap\SitemapGenerator;
use Concrete\Core\Page\Sitemap\SitemapWriter;
use Concrete\Core\Site\Service;
use Concrete\Core\Support\Facade\Application;
use Macareux\MultisiteSitemap\Page\Sitemap\SitemapIndexGenerator;

class GenerateMultisiteSitemapIndexCommandHandler implements OutputAwareInterface
{
    use OutputAwareTrait;

    public function __invoke(GenerateMultisiteSitemapIndexCommand $command): void
    {
        $app = Application::getFacadeApplication();
        /** @var SitemapIndexGenerator $generator */
        $generator = $app->make(SitemapIndexGenerator::class);
        /** @var SitemapWriter $writer */
        $writer = $app->make(SitemapWriter::class);
        $writer->setSitemapGenerator($generator);
        $writer->generate();
        $sitemapUrl = $writer->getSitemapUrl();
        $this->output->write(t('Sitemap URL available at: %s', $sitemapUrl));
    }
}