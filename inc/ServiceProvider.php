<?php

namespace LaunchpadUninstallTakeOff;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use LaunchpadCLI\App;
use LaunchpadCLI\Entities\Configurations;
use LaunchpadCLI\ServiceProviders\ServiceProviderInterface;
use LaunchpadCLI\Templating\Renderer;
use LaunchpadUninstallTakeOff\Commands\InstallCommand;
use LaunchpadUninstallTakeOff\Services\AssetsManager;
use LaunchpadUninstallTakeOff\Services\ProjectManager;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * Interacts with the filesystem.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Configuration from the project.
     *
     * @var Configurations
     */
    protected $configs;

    /**
     * Renderer that handles layout of template files.
     *
     * @var Renderer
     */
    protected $renderer;

    /**
     * Instantiate the class.
     *
     * @param Configurations $configs configuration from the project.
     * @param Filesystem $filesystem Interacts with the filesystem.
     * @param string $app_dir base directory from the cli.
     */
    public function __construct(Configurations $configs, Filesystem $filesystem, string $app_dir)
    {
        $this->configs = $configs;
        $this->filesystem = $filesystem;
        $adapter = new Local(
        // Determine root directory
            __DIR__ . '/../'
        );

        // The FilesystemOperator
        $template_filesystem = new Filesystem($adapter);

        $this->renderer = new Renderer($template_filesystem, '/templates/');
    }

    public function attach_commands(App $app): App
    {

        $assets_manager = new AssetsManager($this->filesystem, $this->renderer, $this->configs);
        $app->add(new InstallCommand($assets_manager));
        return $app;
    }
}
