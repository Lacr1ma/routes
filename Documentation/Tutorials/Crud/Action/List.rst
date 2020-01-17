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

      demo_photos-index:
         path:         api/demo/photos
         controller:   Vendor\Demo\Controller\PhotoApiController::index
         methods:      GET
         format:       json
         options:
            middleware:
               - auth

   .. tip::

      **index** action has been already implemented in our predefined controller.

      **GET** is not required, but as we follow the concept, we should always use it.

      **json** is not required, but it gives a little bit of clarity.

      **auth** FE user session is required as well as proper csrf token.

#. Use defined above endpoint in JavaScript scope.

   .. code-block:: javascript

      listResource('/api/demo/photos').then(function (entities) {
         console.log(entities);
      });

   .. tip::

        **listResource** function has been already implemented in our predefined Routes.js.
