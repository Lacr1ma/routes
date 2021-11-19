.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _format_json:

===================================
JSON Format
===================================

.. code-block:: yaml
   :linenos:
   :emphasize-lines: 4

   demo_clients-test:
      path:         api/demo/clients/test
      controller:   LMS\Demo\Controller\ClientApiController::test
      format:       json
      defaults:
        plugin:     ClientApi

Direct Output
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

.. code-block:: php

    <?php
        declare(strict_types = 1);

        namespace LMS\Demo\Controller;

        use Psr\Http\Message\ResponseInterface;

        class ClientApiController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
        {
            public function testAction(): ResponseInterface
            {
               return $this->jsonResponse(
                  (string)json_encode('status' => 'ok')
               );
            }
        }

Custom View
^^^^^^^^^^^^^^^^^^^

Instead of *Direct Output*, it's possible to create individual view for building the output.
In the current example, :file:`Classes/View/ClientApi/TestJson.php`: expected to be in place.

.. code-block:: php

    <?php
        declare(strict_types = 1);

        namespace LMS\Demo\View\ClientApi;

        class TestJson extends \TYPO3\CMS\Extbase\Mvc\View\AbstractView
        {
            public function render()
            {
                return json_encode(['status' => 'ok']);
            }
        }

Custom Template
^^^^^^^^^^^^^^^^^^^^^^^

Or even alternatively, :file:`Resources/Private/Templates/ClientApi/Test.json`:
expected to be in place.

.. warning::
    :file:`$defaultViewObjectName` should not be overwritten.

.. code-block:: json

   {
     "status": "ok"
   }

Example request
^^^^^^^^^^^^^^^^

.. note::

    :file:`Accept: application/json`

    :file:`Content-Type: application/json`

    Headers are recommended.

.. code-block:: console

    curl --location --request GET 'https://demo.ddev.site/api/demo/clients/test' \
        --header 'Content-Type: application/json' \
        --header 'Accept: application/json'
