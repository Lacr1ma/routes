.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _ts:

TypoScript
==========

Plugin settings
---------------
This section covers all settings, which can be defined in the plugin itself.

Properties
^^^^^^^^^^

.. container:: ts-properties

	==================================== ====================================== ============== ===============
	Property                             Title                                  Sheet          Type
	==================================== ====================================== ============== ===============
	`redirect.loginPage`                  PageId that contains Login Form       General         int
	==================================== ====================================== ============== ===============

redirect.loginPage
"""""""""
.. container:: table-row

   Property
         redirect.loginPage
   Data type
         int
   Description
         Should point to page which contains login form. When route uses ``auth`` middleware
         and user is not logged in while performing the request, redirection to login page is taking place.

         .. note:: Redirection takes place only if request does not have Accept: application/json.
