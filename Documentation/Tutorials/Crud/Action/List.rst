.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _action:

===================================
LIST
===================================

.. rst-class:: bignums-xxl

#. Define appropriate route.

   .. code-block:: yaml
      :linenos:

      demo_list:
         path:         api/demo/entity
         controller:   Vendor\Demo\Controller\DemoApiController::list
         methods:      GET
         options:
            middleware:
               - auth

   .. tip::
      **list** action has been already implemented in our predefined controller.

      **GET** is not required, but as we follow the concept, we should always use it.

      **auth** FE user session is required as well as proper csrf token.

#. Use defined above endpoint in JavaScript scope.

   .. code-block:: javascript

      ...

      listResource('/api/demo/entity').then(function (entities) {
         console.log(entities);
      });

      ...

   .. tip::
         **listResource** function has been already implemented in our predefined Routes.js.
