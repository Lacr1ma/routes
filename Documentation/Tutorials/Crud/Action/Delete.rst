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

      demo_photos-destroy:
         path:         api/demo/photos/{uid}
         controller:   Vendor\Demo\Controller\PhotoApiController::destroy
         methods:      DELETE
         format:       json
         defaults:
            plugin:    PhotoApi
         requirements:
            uid:       \d+
         options:
            middleware:
               - auth

   .. warning::

        If you extend :file:`\LMS\Facade\Controller\AbstractApiController`,

        **uid** must be present and it's name should not be changed.

   .. tip::

      **destroy** action has been already implemented in our predefined controller.

      **DELETE** is not required, but as we follow the concept, we should always use it.

      **json** is not required, but it gives a little bit of clarity.

      **requirements** has *uid* argument and tells us it must be of type integer.

      **auth** FE user session is required as well as proper csrf token.

   .. seealso::

        When the resource must be deleted only by it's creator or limited number of users :ref:`see <verifyuserparams>`

#. Use defined above endpoint in JavaScript scope.

   .. code-block:: javascript

      deleteResource('/api/demo/photos/1').then(function (isOk) {
         console.log(isOk);
      });

   .. tip::

        **deleteResource** function has been already implemented in our predefined Routes.js.
