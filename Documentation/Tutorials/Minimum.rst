.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _minimum:

===================================
Bare Minimum
===================================

This is an example of the minimum layers that should exist.

.. rst-class:: bignums-xxl

1. Define a route (Configuration/Routes.yml)

   .. code-block:: yaml

      extension_demo-test:
         path:         api/demo/test
         controller:   Vendor\Demo\Controller\DemoApiController::test

2. Register Plugin namespace (ext_localconf.php)

    .. include:: ../_Shared/Plugin/DemoApi/Test.rst

3. Create Controller (Classes/Controller/DemoApiController.php)

    .. include:: ../_Shared/Controller/Demo/Test.rst

4. Perform a request

    .. code-block:: console

        curl --location --request GET 'https://demo.ddev.site/api/demo/test'

5. Response

    .. code-block:: json

        {
            "ok": true
        }
