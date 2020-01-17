.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _VerifyCsrfToken_fail:

===================================
Example of failed request
===================================

When request has incorrect csrf token or it's not provided at all.

.. rst-class:: bignums-xxl

Request:
----------

.. code-block:: console

    curl --location --request GET 'https://demo.ddev.site/api/demo/photos/1' --header 'Accept: application/json'

Response:
----------

.. code-block:: json

    {
        "error": "CSRF token mismatch."
    }

.. warning::

     Error responses have code **401**.
