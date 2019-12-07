.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _property:

===================================
Controller
===================================

.. code-block:: yaml
   :linenos:
   :emphasize-lines: 3

   demo:
      path:         clients/{client}
      controller:   LMS\Demo\Controller\DemoApiController::test

.. tip::
   Defines the Extbase Action, that gets triggered during the API request.

   **Required**: Yes
