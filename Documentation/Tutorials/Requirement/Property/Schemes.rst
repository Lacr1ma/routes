.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _property:

===================================
Schemes
===================================

.. code-block:: yaml
   :linenos:
   :emphasize-lines: 4

   demo_test:
      path:         api/demo
      controller:   Vendor\Demo\Controller\DemoApiController::test
      schemes:      [https]

.. tip::
   Route will be triggered only if *scheme* is matched

   **Required**: No

   **Variants**: http | https

.. tip::
      By default ( when schemes is not specified ) both http and https is taking place.
