.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _property:

===================================
Controller
===================================

Defines the Extbase Action, that must be executed when request is triggered.

.. code-block:: yaml
   :linenos:
   :emphasize-lines: 3

   demo_photos-all:
      path:         api/demo/photos
      controller:   LMS\Demo\Controller\PhotoApiController::all
      defaults:
        plugin:     PhotoApi

.. tip::

   **Required**: Yes

.. code-block:: php

   <?php
        declare(strict_types = 1);

        namespace LMS\Demo\Controller;

        use LMS\Demo\Repository\PhotoRepository;

        class PhotoApiController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
        {
            /**
            * @return string
            */
            public function allAction(): string
            {
                $photos = PhotoRepository::make()->findAll()->toArray();

                return json_encode($photos);
            }
        }

.. warning::

    Corresponding plugin should be configured in :file:`ext_localconf.php`

Example request
^^^^^^^^^^^^^^^^

.. code-block:: console

    curl --location --request GET 'https://demo.ddev.site/api/demo/photos' \
        --header 'Content-Type: application/json' \
        --header 'Accept: application/json'
