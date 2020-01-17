.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _verifyuserparams:

===================================
VerifyUser Middleware Parameters
===================================

.. code-block:: yaml

   extension_controller-action:
     requirements:
       user:       \d+
     defaults:
       user:
     options:
       middleware:
         - LMS\Routes\Middleware\Api\VerifyUser:user

.. tip::

     Even if we don't use *user* property in our action it should be provided as a parameter.

     Middleware will check if the passed user is a part of the whitelist.

Properties
^^^^^^^^^^

.. container:: ts-properties

	==================================== ========================================== =====================
	Property                             Title                                      Type
	==================================== ========================================== =====================
	first                                Name of the property that contains user id string
	last                                 The name of the extension with admin users string
	==================================== ========================================== =====================

Admin users ( global scope )
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Sometime you want certain users mark as *admin*.
If user is an admin - grant the access.
For this purpose we can set additional TypoScript variable.

.. tip::

     :file:`plugin.tx_routes.settings.middleware.admin.users = 3,4`.

This will add users who have uid 3 and 4 to a whitelist for every route that guarded by **VerifyUser**.
Why just don't use like 1,2,3,4 ? The answer is rather simple.
When we deal with TypoScript, we can change the value in real time by condition, which is sometimes handy.

Admin users ( extension scope )
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

It will not work for every route, but for those who have added *extension key* to the end.
When extension scope is used, global scope is ignored.

.. code-block:: yaml

   extension_controller-action:
     requirements:
       user:       \d+
     defaults:
       user:
     options:
       middleware:
         - auth
         - LMS\Routes\Middleware\Api\VerifyUser:user,tx_demo

.. tip::

      :file:`plugin.tx_demo.settings.middleware.admin.users = 3,4`
