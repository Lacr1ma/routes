.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _property:

===================================
Schemes
===================================

You can set a rule, that your action will be triggered only by https.
By default ( when schemes is not specified ) protocol is not important,
so both **http** and **https** will pass.

.. code-block:: yaml
   :linenos:
   :emphasize-lines: 4

   demo_clients-destroy:
     path:         api/demo/clients/{uid}
     controller:   LMS\Demo\Controller\ClientApiController::destroy
     schemes:      https
     requirements:
        uid:       \d+

.. tip::

    **Required**: No

    **Variants**: http | https

Multiple protocols
^^^^^^^^^^^^^^^^^^^

You can specify more than just one protocol

.. code-block:: yaml
   :linenos:
   :emphasize-lines: 4

   demo_clients-destroy:
      path:         api/demo/clients/{uid}
      controller:   LMS\Demo\Controller\ClientApiController::destroy
      schemes:      [http, https]
      requirements:
         uid:       \d+
