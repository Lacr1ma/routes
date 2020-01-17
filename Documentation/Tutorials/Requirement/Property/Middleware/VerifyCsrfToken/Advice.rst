.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _VerifyCsrfToken_advice:

===================================
Advice
===================================

Using this middleware without **Authenticate** usually makes no sense.

In most of the cases you really want to have **Authenticate** and **VerifyCsrfToken**
together.

For this situations we recommend to use **auth** group.

.. code-block:: yaml

    middleware:
      - LMS\Routes\Middleware\Api\Authenticate
      - LMS\Routes\Middleware\Api\VerifyCsrfToken

Or (which is the same as above)

.. code-block:: yaml

    middleware:
      - auth
