.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _common_use:

===================================
Using Middleware
===================================

If you would like to assign middleware to specific route,
you should define it under the **middleware** scope of your route definition.

.. code-block:: yaml

   extension_controller-action:
     ...
     options:
       middleware:
         - LMS\Routes\Middleware\Api\Authenticate


Combine middleware
====================

You may also assign multiple middleware to the route.

Just append as many as you need under the **middleware**.

.. code-block:: yaml

   extension_controller-action:
     ...
     options:
       middleware:
         - LMS\Routes\Middleware\Api\Authenticate
         - LMS\Routes\Middleware\Api\VerifyCsrfToken


Middleware Groups
==================

Sometimes you may want to group several middleware under a single key to make them easier to assign to routes.
Out of the box, **EXT:routes** comes with :file:`auth` middleware group that contains common middleware you may want to apply to your web UI and API routes:

.. code-block:: yaml

   extension_controller-action:
     ...
     options:
       middleware:
         - auth

.. note::

   :file:`auth` group just combines (*Authenticate* and *VerifyCsrfToken*) middleware, nothing more.

   You also can create your own custom combinations if needed.


Combine Groups And Middleware
==============================

It's logical, but we should mention that combination of groups and middleware is possible as well.

.. code-block:: yaml

   extension_controller-action:
     ...
     options:
       middleware:
         - auth
         - Vendor\Extension\Middleware\Api\MyCustomMiddleware
         - LMS\Routes\Middleware\Api\VerifyAdminBackendSession
