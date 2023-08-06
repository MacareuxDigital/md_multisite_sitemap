<?php

namespace Macareux\MultisiteSitemap\Task\Controller;

use Concrete\Core\Command\Batch\Batch;
use Concrete\Core\Command\Task\Controller\AbstractController;
use Concrete\Core\Command\Task\Input\InputInterface;
use Concrete\Core\Command\Task\Runner\BatchProcessTaskRunner;
use Concrete\Core\Command\Task\Runner\TaskRunnerInterface;
use Concrete\Core\Command\Task\TaskInterface;
use Concrete\Core\Site\Service;
use Concrete\Core\Support\Facade\Application;
use Macareux\MultisiteSitemap\Page\Sitemap\Command\GenerateMultisiteSitemapCommand;
use Macareux\MultisiteSitemap\Page\Sitemap\Command\GenerateMultisiteSitemapIndexCommand;

class GenerateMultisiteSitemapController extends AbstractController
{

    public function getName(): string
    {
        return t('Generate Multisite Sitemap');
    }

    public function getDescription(): string
    {
        return t('Creates multiple sitemap.xml at the root of your site.');
    }

    public function getTaskRunner(TaskInterface $task, InputInterface $input): TaskRunnerInterface
    {
        $batch = Batch::create();
        $app = Application::getFacadeApplication();
        /** @var Service $service */
        $service = $app->make('site');
        foreach ($service->getList() as $site) {
            $batch->add(new GenerateMultisiteSitemapCommand($site->getSiteID()));
        }
        $batch->add(new GenerateMultisiteSitemapIndexCommand());

        return new BatchProcessTaskRunner($task, $batch, $input, t('Generation of sitemap.xml started.'));
    }
}
