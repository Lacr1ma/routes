.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _property:

===================================
Middleware
===================================

.. code-block:: yaml
   :linenos:
   :emphasize-lines: 6,7

   demo_middleware:
     path:         api/demo/middleware
     controller:   LMS\Demo\Controller\DemoApiController::test
     options:
       middleware:
         - auth
         - LMS\Routes\Middleware\Api\VerifyAdminBackendSession

.. tip::
   Route will be triggered only if all defined middleware pass.

   **Required**: No

   **Variants**: LMS\Routes\Middleware\Api\Authenticate | LMS\Routes\Middleware\Api\VerifyCsrfToken | Vendor\Extension\Middleware\Api\MyCustomMiddleware

.. tip::
      **auth** is just a sugar that combines (Authenticate and VerifyCsrfToken)

Use a custom defined middleware
-------------------------------

.. code-block:: php

   namespace Vendor\Extension\Middleware\Api;

   use Symfony\Component\Routing\Exception\MethodNotAllowedException;

   class MyCustomMiddleware
   {
      /**
      * @param array $arguments
      */
      public function process(array $arguments): void
      {
         $isOk = true; // Replace with your actual logic...

         if ($isOk) {
             return;
         }

         throw new MethodNotAllowedException([], 'Denied!');
      }
   }


.. code-block:: yaml
   :linenos:
   :emphasize-lines: 6

   demo_middleware:
     path:         api/demo/middleware
     controller:   LMS\Demo\Controller\DemoApiController::test
     options:
       middleware:
         - Vendor\Extension\Middleware\Api\MyCustomMiddleware
