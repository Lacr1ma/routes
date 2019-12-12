.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _action:

===================================
DELETE
===================================

.. rst-class:: bignums-xxl

#. Define appropriate route.

   .. code-block:: yaml
      :linenos:

      demo_delete:
         path:         api/demo/photos/{uid}
         controller:   Vendor\Demo\Controller\DemoApiController::destroy
         methods:      DELETE
         requirements:
            uid:        \d+
         options:
            middleware:
               - auth

   .. tip::
      **destroy** action has been already implemented in our predefined controller.

      **DELETE** is not required, but as we follow the concept, we should always use it.

      **requirements** has *uid* argument and tells us it must be of type integer.

      **auth** FE user session is required as well as proper csrf token.

#. Use defined above endpoint in JavaScript scope.

   .. code-block:: javascript

      ...

      deleteResource('/api/demo/photos/1').then(function (isOk) {
         console.log(isOk);
      });

      ...

   .. tip::
         **deleteResource** function has been already implemented in our predefined Routes.js.
