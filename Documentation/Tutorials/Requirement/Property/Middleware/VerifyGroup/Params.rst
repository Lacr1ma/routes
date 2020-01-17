.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _VerifyGroup_params:

===================================
VerifyGroup Middleware Parameters
===================================

.. code-block:: yaml

   extension_controller-action:
     options:
       middleware:
         - auth
         - LMS\Routes\Middleware\Api\VerifyGroup:1,2

Properties
^^^^^^^^^^

.. container:: ts-properties

	==================================== ======================================   =====================
	Property                             Title                                    Type
	==================================== ======================================   =====================
	first ... (N - 1)                    Allowed Groups                           comma separated list
	last                                 The name of the extension with admins    string
	==================================== ======================================   =====================

Admin groups ( global scope )
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Sometime you want certain groups mark as *admin*.
If user is part of the admin group - grant the access.
For this purpose we can set additional TypoScript variable.

.. tip::

     :file:`plugin.tx_routes.settings.middleware.admin.groups = 3,4`.

This will add groups 3,4 to a whitelist for every route that guarded by **VerifyGroup**.
Why just don't use like 1,2,3,4 ? The answer is rather simple.
When we deal with TypoScript, we can change the value in real time by condition, which is sometimes handy.

Admin groups ( extension scope )
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

It will not work for every route, but for those who have added *extension key* to the end.
When extension scope is used, global scope is ignored.

.. code-block:: yaml

   extension_controller-action:
     options:
       middleware:
         - auth
         - LMS\Routes\Middleware\Api\VerifyGroup:1,2,tx_demo

.. tip::

      :file:`plugin.tx_demo.settings.middleware.admin.groups = 3,4`
