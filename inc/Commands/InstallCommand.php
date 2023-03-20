<?php

namespace RocketLauncherUninstallTakeOff\Commands;

use RocketLauncherBuilder\Commands\Command;
use RocketLauncherUninstallTakeOff\Services\AssetsManager;
use RocketLauncherUninstallTakeOff\Services\ConfigsManager;
use RocketLauncherUninstallTakeOff\Services\ProjectManager;

class InstallCommand extends Command
{
    /**
     * @var AssetsManager
     */
    protected $assets_manager;

    /**
     * @var ProjectManager
     */
    protected $project_manager;

    /**
     * @var ConfigsManager
     */
    protected $configs_manager;

    public function __construct(AssetsManager $assets_manager, ProjectManager $project_manager, ConfigsManager $configs_manager)
    {
        $this->assets_manager = $assets_manager;
        $this->project_manager = $project_manager;
        $this->configs_manager = $configs_manager;

        parent::__construct('uninstaller:initialize', 'Initialize the uninstaller library');

        $this
            // Usage examples:
            ->usage(
            // append details or explanation of given example with ` ## ` so they will be uniformly aligned when shown
                '<bold>  $0 uninstaller:initialize</end> ## Initialize the uninstall library<eol/>'
            );
    }

    public function execute() {
        $this->assets_manager->create_uninstall_file();
        $this->configs_manager->set_up_provider();
        $this->project_manager->add_library();
        $this->project_manager->cleanup();
        $this->project_manager->reload();
    }
}
