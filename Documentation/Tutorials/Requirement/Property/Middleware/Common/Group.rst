.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _common_group:

===================================
Middleware Group
===================================

:file:`Auth` middleware group that exists out of the box has next definition.

.. code-block:: typoscript
    :linenos:

    plugin.tx_routes.settings {

        middleware {
            auth {
                10 = LMS\Routes\Middleware\Api\Authenticate
                20 = LMS\Routes\Middleware\Api\VerifyCsrfToken
            }
        }

    }

Create group
==============

To Create your own middleware group, you should extend the middleware key with additional definition.

.. code-block:: typoscript
   :linenos:
   :emphasize-lines: 4,5,6,7,8,9

    plugin.tx_routes.settings {

        middleware {
            admin {
                10 = LMS\Routes\Middleware\Api\Authenticate
                20 = LMS\Routes\Middleware\Api\VerifyCsrfToken
                30 = LMS\Routes\Middleware\Api\VerifyAdminBackendSession
                40 = Vendor\Extension\Middleware\Api\MyCustomMiddleware
            }
        }

    }

.. tip::
    Of course you need to keep the changes outside of the EXT:route. For example in *theme* extension.

After that you are able to use the group as shown bellow:

.. code-block:: yaml
   :linenos:
   :emphasize-lines: 5

   extension_controller-action:
     ...
     options:
       middleware:
         - admin
