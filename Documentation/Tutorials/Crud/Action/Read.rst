.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _action:

===================================
READ
===================================

.. rst-class:: bignums-xxl

#. Define appropriate route.

   .. code-block:: yaml
      :linenos:

      demo_show:
         path:         api/demo/entity/{uid}
         controller:   Vendor\Demo\Controller\DemoApiController::show
         methods:      GET
         requirements:
            uid:        \d+
         options:
            middleware:
               - auth

   .. tip::
      **show** action has been already implemented in our predefined controller.

      **GET** is not required, but as we follow the concept, we should always use it.

      **requirements** has *uid* argument and tells us it must be of type integer.

      **auth** FE user session is required as well as proper csrf token.

#. Use defined above endpoint in JavaScript scope.

   .. code-block:: javascript

      ...

      readResource('/api/demo/entity/1').then(function (entity) {
         console.log(entity);
      });

      ...

   .. tip::
         **readResource** function has been already implemented in our predefined Routes.js.
