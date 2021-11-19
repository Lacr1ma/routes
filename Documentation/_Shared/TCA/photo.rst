.. code-block:: php

    <?php
        declare(strict_types = 1);

        return [
            'ctrl' => [
                'title' => 'Photo',
                'label' => 'url',
                'crdate' => 'crdate',
                'delete' => 'deleted',
                'searchFields' => 'url'
            ],
            'types' => [
                '1' => [
                    'showitem' => '
                        url
                    '
                ]
            ],
            'columns' => [
                'url' => [
                    'exclude' => true,
                    'label' => 'Url',
                    'config' => [
                        'type' => 'input',
                        'eval' => 'trim'
                    ]
                ]
            ]
        ];
