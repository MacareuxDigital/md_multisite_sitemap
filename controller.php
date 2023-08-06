<?php

namespace Concrete\Package\MdMultisiteSitemap;

use Concrete\Core\Command\Task\Manager as TaskManager;
use Concrete\Core\Package\Package;
use Illuminate\Contracts\Container\BindingResolutionException;
use Macareux\MultisiteSitemap\Task\Controller\GenerateMultisiteSitemapController;
use Mitsumura\Task\Controller\FixCommaController;

/**
 * Package Controller.
 *
 * @see https://documentation.concretecms.org/developers/packages/directory-icon-controller
 */
class Controller extends Package
{
    /**
     * The minimum Concrete version compatible with this package.
     *
     * @var string
     */
    protected $appVersionRequired = '9.0.0';

    /**
     * The handle of this package.
     *
     * @var string
     */
    protected $pkgHandle = 'md_multisite_sitemap';

    /**
     * The version number of this package.
     *
     * @var string
     */
    protected $pkgVersion = '0.0.1';

    /**
     * @see https://documentation.concretecms.org/developers/packages/adding-custom-code-to-packages
     *
     * @var string[]
     */
    protected $pkgAutoloaderRegistries = [
        'src' => '\Macareux\MultisiteSitemap',
    ];

    /**
     * Get the translated name of the package.
     *
     * @return string
     */
    public function getPackageName(): string
    {
        return t('Macareux Multisite Sitemap');
    }

    /**
     * Get the translated package description.
     *
     * @return string
     */
    public function getPackageDescription(): string
    {
        return t('A package contains a task to generate multisite sitemap.xml.');
    }

    /**
     * Install this package.
     *
     * @see https://documentation.concretecms.org/developers/packages/installation/overview
     *
     * @return \Concrete\Core\Entity\Package
     */
    public function install(): \Concrete\Core\Entity\Package
    {
        $package = parent::install();

        $this->installContentFile('install/tasks.xml');

        return $package;
    }

    /**
     * This method called on every page load
     *
     * @return void
     * @throws BindingResolutionException
     * @see \Concrete\Core\Application\Application::setupPackages
     *
     */
    public function on_start(): void
    {
        /** @var TaskManager $taskManager */
        $taskManager = $this->app->make(TaskManager::class);
        $taskManager->extend('generate_multisite_sitemap', static function() {
            return app(GenerateMultisiteSitemapController::class);
        });
    }
}