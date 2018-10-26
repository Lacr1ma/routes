<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Extbase Yaml Routes',
    'description' => 'Provides an ability to bind a route slug to the certain Extbase Action endpoint.',
    'category' => 'fe',
    'author' => 'Borulko Serhii',
    'author_email' => 'borulkosergey@icloud.com',
    'state' => 'alpha',
    'clearCacheOnLoad' => true,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-9.5.99'
        ]
    ]
];
