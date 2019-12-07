.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _action:

===================================
UPDATE
===================================

.. rst-class:: bignums-xxl

#. Define appropriate route.

   .. code-block:: yaml
      :linenos:

      demo_update:
         path:         api/demo/entity/{uid}
         controller:   Vendor\Demo\Controller\DemoApiController::edit
         methods:      PUT
         requirements:
            uid:        \d+
         defaults:
            data:
         options:
            middleware:
               - auth

   .. tip::
      **edit** action has been already implemented in our predefined controller.

      **PUT** is not required, but as we follow the concept, we should always use it.

      **requirements** has *uid* argument and tells us it must be of type integer.

      **data** is required argument here, as we later pass data that will be placed inside *data* argument.

      **auth** FE user session is required as well as proper csrf token.

#. Use defined above endpoint in JavaScript scope.

   .. code-block:: javascript

      ...

      updateResource('/api/demo/entity/1', {title: 'Title 1'}).then(function (isOk) {
         console.log(isOk);
      });

      ...

   .. tip::
         **updateResource** function has been already implemented in our predefined Routes.js.
