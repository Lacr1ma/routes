.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _property:

===================================
Methods
===================================

It's possible to limit the route by certain list of request method(s).
This technique widely used in the modern API solutions.
By default ( when methods is not specified ) route accepts any request methods.

.. code-block:: yaml
   :linenos:
   :emphasize-lines: 4

   demo_clients-destroy:
      path:         api/demo/clients/{uid}
      controller:   LMS\Demo\Controller\ClientApiController::destroy
      methods:      DELETE
      requirements:
         uid:       \d+

.. tip::
   **Required**: No

   **Variants**: GET | POST | DELETE | PUT

Multiple methods
^^^^^^^^^^^^^^^^

You can specify more than just one method for your route.

.. code-block:: yaml
   :linenos:
   :emphasize-lines: 4

   demo_clients-destroy:
      path:         api/demo/clients/{uid}
      controller:   LMS\Demo\Controller\ClientApiController::destroy
      methods:      [DELETE, PUT]
      requirements:
         uid:       \d+
