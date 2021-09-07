<?php
return [
    'BE' => [
        'debug' => true,
        'explicitADmode' => 'explicitAllow',
        'installToolPassword' => '$argon2i$v=19$m=65536,t=16,p=1$Z003blU1WWZ0aDBvUXVEeQ$OE5PlJA7vwYCPWBNoT4klC8z7F9WLoP0E1CvU1pfulg',
        'passwordHashing' => [
            'className' => 'TYPO3\\CMS\\Core\\Crypto\\PasswordHashing\\Argon2iPasswordHash',
            'options' => [],
        ],
    ],
    'DB' => [
        'Connections' => [
            'Default' => [
                'charset' => 'utf8',
                'driver' => 'mysqli',
            ],
        ],
    ],
    'EXTENSIONS' => [
        'backend' => [
            'backendFavicon' => '',
            'backendLogo' => '',
            'loginBackgroundImage' => '',
            'loginFootnote' => '',
            'loginHighlightColor' => '',
            'loginLogo' => '',
            'loginLogoAlt' => '',
        ],
        'extensionmanager' => [
            'automaticInstallation' => '1',
            'offlineMode' => '0',
        ],
    ],
    'FE' => [
        'debug' => true,
        'disableNoCacheParameter' => true,
        'passwordHashing' => [
            'className' => 'TYPO3\\CMS\\Core\\Crypto\\PasswordHashing\\Argon2iPasswordHash',
            'options' => [],
        ],
    ],
    'GFX' => [
        'processor' => 'ImageMagick',
        'processor_allowTemporaryMasksAsPng' => false,
        'processor_colorspace' => 'sRGB',
        'processor_effects' => true,
        'processor_enabled' => true,
        'processor_path' => '/usr/bin/',
        'processor_path_lzw' => '/usr/bin/',
    ],
    'LOG' => [
        'TYPO3' => [
            'CMS' => [
                'deprecations' => [
                    'writerConfiguration' => [
                        'notice' => [
                            'TYPO3\CMS\Core\Log\Writer\FileWriter' => [
                                'disabled' => false,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'MAIL' => [
        'transport' => 'sendmail',
        'transport_sendmail_command' => '/usr/local/bin/mailhog sendmail test@example.org --smtp-addr 127.0.0.1:1025',
        'transport_smtp_encrypt' => '',
        'transport_smtp_password' => '',
        'transport_smtp_server' => '',
        'transport_smtp_username' => '',
    ],
    'SYS' => [
        'caching' => [
            'cacheConfigurations' => [
                'hash' => [
                    'backend' => 'TYPO3\\CMS\\Core\\Cache\\Backend\\Typo3DatabaseBackend',
                ],
                'imagesizes' => [
                    'backend' => 'TYPO3\\CMS\\Core\\Cache\\Backend\\Typo3DatabaseBackend',
                    'options' => [
                        'compression' => true,
                    ],
                ],
                'pages' => [
                    'backend' => 'TYPO3\\CMS\\Core\\Cache\\Backend\\Typo3DatabaseBackend',
                    'options' => [
                        'compression' => true,
                    ],
                ],
                'pagesection' => [
                    'backend' => 'TYPO3\\CMS\\Core\\Cache\\Backend\\Typo3DatabaseBackend',
                    'options' => [
                        'compression' => true,
                    ],
                ],
                'rootline' => [
                    'backend' => 'TYPO3\\CMS\\Core\\Cache\\Backend\\Typo3DatabaseBackend',
                    'options' => [
                        'compression' => true,
                    ],
                ],
            ],
        ],
        'devIPmask' => '*',
        'displayErrors' => 1,
        'encryptionKey' => 'ffb7adc25d4315322f4e573b7ac655168f909600661449e5b57bb9b42568961fb5a4275eefbb31213119bdf09f893804',
        'exceptionalErrors' => 12290,
        'features' => [
            'unifiedPageTranslationHandling' => true,
            'yamlImportsFollowDeclarationOrder' => true,
        ],
        'sitename' => 'Demo',
        'systemMaintainers' => [
            1,
        ],
    ],
];
