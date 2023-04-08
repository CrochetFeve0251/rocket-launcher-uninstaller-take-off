<?php

namespace LaunchpadUninstallTakeOff\Commands;

use LaunchpadCLI\Commands\Command;
use LaunchpadUninstallTakeOff\Services\AssetsManager;
use LaunchpadUninstallTakeOff\Services\ProjectManager;

class InstallCommand extends Command
{
    /**
     * @var AssetsManager
     */
    protected $assets_manager;

    public function __construct(AssetsManager $assets_manager)
    {
        $this->assets_manager = $assets_manager;

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
    }
}
