.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _property:

===================================
Plugin
===================================

Contains the plugin name from **ext_localconf.php**.

.. code-block:: php
   :linenos:
   :emphasize-lines: 3

   use LMS\Demo\Controller\ClientApiController;

   \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
       'Demo',
       'Client',
       [
           ClientApi::class => 'index'
       ],
       [
           ClientApi::class => 'index'
       ]
   );

.. code-block:: yaml
   :linenos:
   :emphasize-lines: 4,5

   demo_clients-index:
      path:         api/demo/clients
      controller:   LMS\Demo\Controller\ClientApiController::index
      defaults:
        plugin:     Client

Example request
^^^^^^^^^^^^^^^^

.. code-block:: console

    curl --location --request GET 'https://demo.ddev.site/api/demo/clients' \
        --header 'Content-Type: application/json' \
        --header 'Accept: application/json'
