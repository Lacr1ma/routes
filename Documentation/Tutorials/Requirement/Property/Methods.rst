.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _property:

===================================
Methods
===================================

.. code-block:: yaml
   :linenos:
   :emphasize-lines: 4

   demo_remove:
      path:         clients/{client}
      controller:   LMS\Demo\Controller\DemoApiController::test
      methods:      [DELETE]
      requirements:
         client:    \d+

.. tip::
   Route will be triggered only if *methods* is matched

   **Required**: No

   **Variants**: GET | POST | DELETE | PUT

.. tip::
      By default ( when methods is not specified ) any method is okey.
