<?php

namespace RocketLauncherUninstallTakeOff;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use RocketLauncherBuilder\App;
use RocketLauncherBuilder\Entities\Configurations;
use RocketLauncherBuilder\ServiceProviders\ServiceProviderInterface;
use RocketLauncherBuilder\Templating\Renderer;
use RocketLauncherUninstallTakeOff\Commands\InstallCommand;
use RocketLauncherUninstallTakeOff\Services\AssetsManager;
use RocketLauncherUninstallTakeOff\Services\ProjectManager;

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
        $project_manager = new ProjectManager($this->filesystem);
        $app->add(new InstallCommand($assets_manager, $project_manager));
        return $app;
    }
}
