<?php

namespace Macareux\MultisiteSitemap\Page\Sitemap\Command;

use Concrete\Core\Foundation\Command\Command;

class GenerateMultisiteSitemapCommand extends Command
{
    protected int $siteID;

    /**
     * @param int $siteID
     */
    public function __construct(int $siteID)
    {
        $this->siteID = $siteID;
    }

    public function getSiteID(): int
    {
        return $this->siteID;
    }
}
