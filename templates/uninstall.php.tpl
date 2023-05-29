<?php

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

use {{ base_namespace }}Dependencies\LaunchpadUninstaller\Uninstall\Uninstall;
use {{ base_namespace }}Dependencies\League\Container\Container;

$plugin_root_dir = dirname( __FILE__ );

require_once $plugin_root_dir . '/vendor/autoload.php';


$params = require_once $plugin_root_dir . '/configs/parameters.php';
$providers = require_once $plugin_root_dir . '/configs/providers.php';

Uninstall::set_container(new Container());
Uninstall::set_params($params);
Uninstall::set_providers($providers);

Uninstall::uninstall_plugin();
