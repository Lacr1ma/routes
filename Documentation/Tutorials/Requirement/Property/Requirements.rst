.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _property:

===================================
Requirements
===================================

.. code-block:: yaml
   :linenos:
   :emphasize-lines: 5

   demo:
      path:         clients/{client}
      controller:   LMS\Demo\Controller\DemoApiController::test
      requirements:
         client:    \d+

.. tip::
   Route will be triggered only if *client* is of type integer

   **Required**: No

   **Variants**:  Use symfony documentation to get more information about possible variants.
