<?php

return [
    'vfs_dir' => '/',
    'structure' => [
        'configs' => [
            'parameters.php' => file_get_contents(ROCKER_LAUNCHER_UNINSTALLER_TAKE_OFF_TESTS_FIXTURES_DIR . '/files/configs/parameters.php'),
            'providers.php' => file_get_contents(ROCKER_LAUNCHER_UNINSTALLER_TAKE_OFF_TESTS_FIXTURES_DIR . '/files/configs/providers.php'),
        ],
        'bin' => [
            'generator' =>   file_get_contents(ROCKER_LAUNCHER_UNINSTALLER_TAKE_OFF_TESTS_FIXTURES_DIR . '/files/bin/generator'),
        ],
        'composer.json' => file_get_contents(ROCKER_LAUNCHER_UNINSTALLER_TAKE_OFF_TESTS_FIXTURES_DIR . '/files/composer.json'),
    ],
    'test_data' => [
        'shouldTransform' => [
            'config' => [
                'files' => [
                    'composer.json' => [
                        'exists' => true,
                        'content' => file_get_contents(ROCKER_LAUNCHER_UNINSTALLER_TAKE_OFF_TESTS_FIXTURES_DIR . '/files/composer.json')
                    ],
                    'configs/parameters.php' => [
                        'exists' => true,
                        'content' => file_get_contents(ROCKER_LAUNCHER_UNINSTALLER_TAKE_OFF_TESTS_FIXTURES_DIR . '/files/configs/parameters.php')
                    ],
                    'configs/providers.php' => [
                        'exists' => true,
                        'content' => file_get_contents(ROCKER_LAUNCHER_UNINSTALLER_TAKE_OFF_TESTS_FIXTURES_DIR . '/files/configs/providers.php')
                    ],
                    'bin/generator' => [
                        'exists' => true,
                        'content' => file_get_contents(ROCKER_LAUNCHER_UNINSTALLER_TAKE_OFF_TESTS_FIXTURES_DIR . '/files/bin/generator')
                    ],
                    'uninstall.php' => [
                        'exists' => false,
                    ],
                ]
            ],
            'expected' => [
                'files' => [
                    'configs/parameters.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/configs/parameters.php')
                    ],
                    'configs/providers.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/configs/providers.php')
                    ],
                    'uninstall.php' => [
                        'exists' => true,
                        'content' => file_get_contents(__DIR__ . '/files/uninstall.php')
                    ],
                ]
            ]
        ],
    ]
];
