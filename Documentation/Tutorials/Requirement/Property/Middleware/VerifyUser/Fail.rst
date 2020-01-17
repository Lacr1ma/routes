.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _VerifyUser_fail:

===================================
Example of failed request
===================================

When request done by user who is not a member of middleware whitelist.

.. rst-class:: bignums-xxl

Request:
----------

.. code-block:: console

    curl --location --request GET 'https://demo.ddev.site/api/demo/photos/1?user=55' \
        --header 'Content-Type: application/json' \
        --header 'Accept: application/json' \
        --header 'Cookie: fe_typo_user=53574eb0bafe1c0a4d8a2cfc0cf726dd \
        --header 'X-CSRF-TOKEN: 53574eb0bafe1c0a4d8a2cfc0cf726dd'

Response:
----------

.. code-block:: json

    {
        "error": "User is not a resource owner."
    }

.. warning::

     Error responses have code **403**.
