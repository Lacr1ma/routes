.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _common_params:

===================================
Middleware Parameters
===================================

Middleware can also receive additional parameters.
For example, if your application needs to verify that the authenticated user has
a given "group" before performing a given action, you could use a
:file:`VerifyGroup` middleware that receives a list of required user groups as an argument.

Middleware parameters may be specified when defining the route by separating
the middleware name and parameters with a :file:`:`.

.. code-block:: yaml
   :linenos:

   extension_controller-action:
     ...
     options:
       middleware:
         - LMS\Routes\Middleware\Api\VerifyGroup:1

Multiple parameters should be delimited by commas:

.. code-block:: yaml
   :linenos:

   extension_controller-action:
     ...
     options:
       middleware:
         - LMS\Routes\Middleware\Api\VerifyGroup:1,2,3
