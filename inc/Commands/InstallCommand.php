<?php

namespace RocketLauncherUninstallTakeOff\Commands;

use RocketLauncherBuilder\Commands\Command;
use RocketLauncherUninstallTakeOff\Services\AssetsManager;
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

    public function __construct(AssetsManager $assets_manager, ProjectManager $project_manager)
    {
        $this->assets_manager = $assets_manager;
        $this->project_manager = $project_manager;

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
        $this->project_manager->add_library();
        $this->project_manager->cleanup();
        $this->project_manager->reload();
    }
}
