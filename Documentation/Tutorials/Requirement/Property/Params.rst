.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _params:

===================================
Defaults
===================================

There's an option that allows us to set the default values for request parameters
in those cases when they aren't passed implicitly.

.. code-block:: yaml
   :linenos:
   :emphasize-lines: 5

    demo_clients-show:
        path:         api/demo/clients/{uid}
        controller:   LMS\Demo\Controller\ClientApiController::show
        defaults:
            title:    my-title
            plugin:   ClientApi
        requirements:
            uid:      \d+

.. tip::

   **Required**: No

When **title** is not passed during the  request, *my-title* will be provided as an action parameter.
