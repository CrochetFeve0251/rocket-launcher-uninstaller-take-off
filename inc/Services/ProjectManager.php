<?php

namespace RocketLauncherUninstallTakeOff\Services;
use Composer\Command\InstallCommand;
use Composer\EventDispatcher\ScriptExecutionException;
use Composer\IO\NullIO;
use League\Flysystem\Filesystem;
use Composer\Factory;

use RocketLauncherUninstallTakeOff\ServiceProvider;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
class ProjectManager
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    const PROJECT_FILE = 'composer.json';
    const BUILDER_FILE = 'bin/generator';

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function reload() {

        if(defined('WPMEDIA_IS_TESTING')) {
            return;
        }

        $this->filesystem->deleteDir('inc/Dependencies');
        $this->filesystem->createDir('inc/Dependencies');

        $jsonFile = $this->filesystem->getAdapter()->getPathPrefix() . 'composer.json';

        $composer = Factory::create(new NullIO(), $jsonFile);
        $command = new InstallCommand();
        $command->setComposer($composer);
        $arguments = array(
            '--no-scripts' => true,
        );
        $command->addOption('no-plugins');
        $command->addOption('no-scripts');
        $input = new ArrayInput($arguments);
        $output = new BufferedOutput();
        try {
            $command->run($input, $output);
        } catch (ScriptExecutionException $e) {

        }
    }

    public function cleanup() {
        $content = $this->filesystem->read(self::BUILDER_FILE);

        $content = preg_replace('/\n *\\\\' . preg_quote(ServiceProvider::class) . '::class,\n/', '', $content);

        $this->filesystem->update(self::BUILDER_FILE, $content);

        $content = $this->filesystem->read(self::PROJECT_FILE);

        $json = json_decode($content, true);

        if(key_exists('require-dev', $json) && key_exists('crochetfeve0251/rocket-launcher-uninstaller-take-off', $json['require-dev'])) {
            unset($json['require-dev']['crochetfeve0251/rocket-launcher-uninstaller-take-off']);
        }

        $content = json_encode($json, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) . "\n";

        $this->filesystem->update(self::PROJECT_FILE, $content);
    }

    public function add_library() {
        if( ! $this->filesystem->has(self::PROJECT_FILE)) {
            return false;
        }

        $content = $this->filesystem->read(self::PROJECT_FILE);
        $json = json_decode($content,true);
        if(! $json || ! array_key_exists('require-dev', $json) || ! array_key_exists('extra', $json) || ! array_key_exists('mozart', $json['extra']) || ! array_key_exists('packages', $json['extra']['mozart'])) {
            return false;
        }

        if(! key_exists('crochetfeve0251/rocket-launcher-uninstaller', $json['require-dev'])) {
            $json['require-dev']['crochetfeve0251/rocket-launcher-uninstaller'] = '^0.0.1';
        }

        if(! in_array('crochetfeve0251/rocket-launcher-uninstaller', $json['extra']['mozart']['packages'])) {
            $json['extra']['mozart']['packages'][] = 'crochetfeve0251/rocket-launcher-uninstaller';
        }

        $content = json_encode($json, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) . "\n";
        $this->filesystem->update(self::PROJECT_FILE, $content);

        return true;
    }

}
