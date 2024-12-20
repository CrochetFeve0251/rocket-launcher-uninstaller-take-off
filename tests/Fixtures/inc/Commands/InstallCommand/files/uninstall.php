<?php

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

use RocketLauncher\Dependencies\LaunchpadDispatcher\Dispatcher;
use RocketLauncher\Dependencies\LaunchpadUninstaller\Uninstall\Uninstall;
use RocketLauncher\Dependencies\League\Container\Container;

$plugin_root_dir = dirname( __FILE__ );

require_once $plugin_root_dir . '/vendor/autoload.php';


$params = require_once $plugin_root_dir . '/configs/parameters.php';
$providers = require_once $plugin_root_dir . '/configs/providers.php';

$container = new Container();
if( key_exists('autowiring', $params) && $params['autowiring']) {
	$reflection_container = new \LaunchpadCore\Container\Autowiring\Container();
	$container->delegate( $reflection_container );
}

Uninstall::set_container($container);
Uninstall::set_dispatcher(new Dispatcher());
Uninstall::set_params($params);
Uninstall::set_providers($providers);

Uninstall::uninstall_plugin();
