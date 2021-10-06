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

   \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
       'LMS.demo',
       'Client',
       [
           'ClientApi' => 'index'
       ],
       [
           'DemoApi' => 'index'
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

.. tip::
   Since v10 this property is **required**.

Example request
^^^^^^^^^^^^^^^^

.. code-block:: console

    curl --location --request GET 'https://demo.ddev.site/api/demo/clients' \
        --header 'Content-Type: application/json' \
        --header 'Accept: application/json'
