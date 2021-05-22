.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _middleware:

Middleware
---------------

Introduction
==============

Middleware provide a convenient mechanism for filtering HTTP requests entering your application.
For example, EXT:routes includes a middleware that verifies the user of your application is authenticated.
If the user is not authenticated, the middleware will redirect the user to the login screen.
However, if the user is authenticated, the middleware will allow the request to proceed further into the application.


Additional middleware can be written to perform a variety of tasks besides authentication.
A CORS middleware might be responsible for adding the proper headers to all responses leaving your application.
A logging middleware might log all incoming requests to your application.


There are several middleware included in the EXT:routes, including middleware for authentication and CSRF protection.
All of these middleware are located in the :file:`Classes/Middleware/Api` directory.

.. tip::

    $GLOBALS['TYPO3_CONF_VARS']['FE']['disableRoutesMiddleware'] = true;

    Allows you to disable all middleware checkers!

.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   Middleware/Common/Index
   Middleware/Authenticate/Index
   Middleware/VerifyCsrfToken/Index
   Middleware/Throttle/Index
   Middleware/VerifyAdminBackendSession/Index
   Middleware/VerifyGroup/Index
   Middleware/VerifyUser/Index
   Middleware/Custom
