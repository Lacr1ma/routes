.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _Middleware_custom:

===================================
Custom Middleware
===================================

Sometimes there's a need to restrict the api calls by specific domain related logic.

For this situations it's possible to create your own middleware.

.. code-block:: yaml
   :emphasize-lines: 13

   demo_photos-show:
     path:         api/demo/photos/{photo}
     controller:   LMS\Demo\Controller\PhotoApiController::show
     methods:      GET
     format:       json
     requirements:
       photo:      \d+
     defaults:
       plugin:     PhotoApi
       photo:
     options:
       middleware:
         - Vendor\Extension\Middleware\Api\CheckRoleMiddleware:editor

.. code-block:: php

    <?php
        declare(strict_types = 1);

        namespace Vendor\Extension\Middleware\Api;

        class CheckRoleMiddleware extends \LMS\Routes\Middleware\Api\AbstractRouteMiddleware
        {
            /**
            * {@inheritDoc}
            */
            public function process(): void
            {
                if ($this->getMiddlewareRole() === $user->getRole()) {
                    return;
                }

                $this->deny('I deny, because i can...', 401);
            }

            private function getMiddlewareRole(): string
            {
                return (string)$this->getProperties()[0];
            }
        }

Retrieve middleware parameters
==============

To get the parameters that is set for middleware you can use the

:file:`$this->getProperties()` function which basically returns an array
that contains all the parameters by it's index.

.. code-block:: yaml

    middleware:
        - Vendor\Extension\Middleware\Api\CheckRoleMiddleware:editor,15

.. code-block:: php

    $this->getProperties() // [0 => 'editor' , 1 => 15]

    $this->getProperties()[0] // editor

    $this->getProperties()[1] // 15

Retrieve user who performed the request in the middleware
==============

There's a handy method :file:`$this->getUser()` which returns
the uid of the user who had performed the request.
