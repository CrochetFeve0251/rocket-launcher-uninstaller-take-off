<?php

namespace RocketLauncherUninstallTakeOff\Services;

use League\Flysystem\Filesystem;
use RocketLauncherBuilder\Entities\Configurations;
use RocketLauncherBuilder\Templating\Renderer;

class AssetsManager
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var Renderer
     */
    protected $renderer;

    protected $configurations;

    /**
     * @param Filesystem $filesystem
     * @param Renderer $renderer
     */
    public function __construct(Filesystem $filesystem, Renderer $renderer, Configurations $configurations)
    {
        $this->filesystem = $filesystem;
        $this->renderer = $renderer;
        $this->configurations = $configurations;
    }

    public function create_uninstall_file() {

        $file = 'uninstall.php';

        $content = $this->renderer->apply_template('uninstall.php.tpl',  [
           'base_namespace' => $this->configurations->getBaseNamespace()
        ]);

        if ( ! $this->filesystem->has($file) ) {
            $this->filesystem->write($file, $content);
            return;
        }

        $this->filesystem->update($file, $content);
    }
}
