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
	cacheDirectoryPath                    Cache directory path                  General         string
	suffix                                Route Location Path                   General         string
	`redirect.loginPage`                  PageId that contains Login Form       General         int
	==================================== ====================================== ============== ===============

.. _cacheDirectoryPath:

cacheDirectoryPath
"""""""
.. container:: table-row

   Property
         cacheDirectoryPath
   Data type
         string
   Description
         Route configuration data could be cached and placed in specific directory.
         You can specify a directory if you need caching.

         .. note:: If set, any route changes will be available after deleting the cache file manually!

.. _suffix:

suffix
""""""""""""""
.. container:: table-row

   Property
         suffix
   Data type
         string
   Description
         By default route extension scans user-defined routes under the ``EXT:my_extension/Configuration/``

         :typoscript:`plugin.tx_routes.settings.suffix = /Configuration`

.. _redirect.loginPage:

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
