.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _VerifyAdminBackendSession_given:

===================================
Preparation
===================================

Let's say we have a :file:`show` method that we want to trigger using the route.
We also have an intention to protect the route by **VerifyAdminBackendSession** middleware.

.. rst-class:: bignums-xxl

1. Define a route (Configuration/Routes.yml)

    .. code-block:: yaml
       :linenos:
       :emphasize-lines: 13

       demo_photos-show:
         path:         api/demo/photos/{photo}
         controller:   LMS\Demo\Controller\PhotoApiController::show
         methods:      GET
         format:       json
         requirements:
           photo:      \d+
         defaults:
           plugin:     PhotoApi
           photo:
         options:
           middleware:
             - LMS\Routes\Middleware\Api\VerifyAdminBackendSession

2. Register Plugin namespace (ext_localconf.php)

    .. code-block:: php

       use LMS\Demo\Controller\PhotoApiController;

       \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
           'Demo',
           'PhotoApi',
           [
              PhotoApi::class => 'show'
           ],
           [
              PhotoApi::class => 'show'
           ]
       );

    .. tip::
        It's not required to register the plugin under :file:`Configuration/TCA/Overrides/tt_content.php`

3. Create **photo** table (ext_tables.sql)

    .. code-block:: sql

        CREATE TABLE tx_demo_domain_model_photo (
            url varchar(128) DEFAULT '' NOT NULL
        );

4. Create entity TCA (Configuration/TCA/tx_demo_domain_model_photo.php)

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

5. Create model (Classes/Domain/Model/Photo.php)

    .. code-block:: php

        <?php
            declare(strict_types = 1);

            namespace LMS\Demo\Domain\Model;

            class Photo extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
            {
                protected string $url = '';

                public function getUrl(): string
                {
                    return $this->url;
                }
            }

6. Create Controller (Classes/Controller/PhotoApiController.php)

    .. code-block:: php

        <?php
            declare(strict_types = 1);

            namespace LMS\Demo\Controller;

            use LMS\Demo\Domain\Model\Photo;
            use Psr\Http\Message\ResponseInterface;

            class PhotoApiController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
            {
                public function showAction(Photo $photo): ResponseInterface
                {
                     return $this->jsonResponse(
                            (string)json_encode(
                                   $photo->_getProperties()
                            )
                     );
                }
            }


.. tip::
    Of course, you can skip steps 3, 4, 5 if you are not dealing with models.
