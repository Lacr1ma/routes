.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _action:

===================================
CREATE
===================================

.. rst-class:: bignums-xxl

#. Define appropriate route.

   .. code-block:: yaml
      :linenos:

      demo_create:
         path:         api/demo/entity
         controller:   Vendor\Demo\Controller\DemoApiController::create
         methods:      POST
         defaults:
            data:
         options:
            middleware:
               - auth


   .. tip::
      **create** action has been already implemented in our predefined controller.

      **POST** is not required, but as we follow the concept, we should always use it.

      **data** is required argument here, as we later pass data that will be placed inside *data* argument.

      **auth** FE user session is required as well as proper csrf token.

#. Use defined above endpoint in JavaScript scope.

   .. code-block:: javascript

      ...

      createResource('/api/demo/entity', {title: 'My new entity'}).then(function (isOk) {
         console.log(isOk);
      });

      ...

   .. tip::
         **createResource** function has been already implemented in our predefined Routes.js.
