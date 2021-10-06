.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _property:

===================================
Path
===================================

It's basically the *URL* you want to define for your route.

.. code-block:: yaml
   :linenos:
   :emphasize-lines: 2

   demo_clients-index:
      path:         api/demo/clients
      controller:   LMS\Demo\Controller\ClientApiController::index
      defaults:
        plugin:     ClientApi

.. tip::
   **Required**: Yes

Example request
^^^^^^^^^^^^^^^^

.. code-block:: console

    curl --location --request GET 'https://demo.ddev.site/api/demo/clients' \
        --header 'Content-Type: application/json' \
        --header 'Accept: application/json'
