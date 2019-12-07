.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _property:

===================================
Defaults
===================================

.. code-block:: yaml
   :linenos:
   :emphasize-lines: 5,6

   demo_action_with_params:
      path:          api/demo/test/with_params
      controller:    LMS\Demo\Controller\DemoApiController::test
      defaults:
         title:       default-title
         description: default-description

.. tip::
   **Required**: No

.. tip::
   When **title** is not passed during the  request, *default-title* will be provided as an action parameter.

   When **description** is not passed during the request, *default-description* will be provided as an action parameter.
