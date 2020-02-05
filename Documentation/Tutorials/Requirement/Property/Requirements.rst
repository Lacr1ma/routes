.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _property:

===================================
Requirements
===================================

If you have any route parameters, there's an option where you can limit the
possible values for them. For instance, you can validate that :file:`{client}` must be
of type integer.

.. code-block:: yaml
   :linenos:
   :emphasize-lines: 5

   demo_clients-show:
      path:         api/demo/clients/{uid}
      controller:   LMS\Demo\Controller\ClientApiController::show
      requirements:
         uid:       \d+
      defaults:
         plugin:    ClientApi

.. tip::

    **Required**: No

    **Variants**:  Use symfony documentation to get more information about possible variants.
