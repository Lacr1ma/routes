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

      demo_photos-update:
         path:         api/demo/photos/{uid}
         controller:   Vendor\Demo\Controller\PhotoApiController::update
         methods:      PUT
         format:       json
         requirements:
            uid:       \d+
         defaults:
            data:
         options:
            middleware:
               - auth

   .. warning::

        If you extend :file:`\LMS\Facade\Controller\AbstractApiController`,

        **uid** must be present and it's name should not be changed.

   .. tip::

      **update** action has been already implemented in our predefined controller.

      **PUT** is not required, but as we follow the concept, we should always use it.

      **json** is not required, but it gives a little bit of clarity.

      **requirements** has *uid* argument and tells us it must be of type integer.

      **data** is required argument here, as we later pass data that will be placed inside *data* argument.

      **auth** FE user session is required as well as proper csrf token.

#. Use defined above endpoint in JavaScript scope.

   .. code-block:: javascript

      updateResource('/api/demo/photos/1', {title: 'Title 1'}).then(function (isOk) {
         console.log(isOk);
      });

   .. tip::

        **updateResource** function has been already implemented in our predefined Routes.js.
