.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _VerifyGroup_success:

===================================
Example of success request
===================================

When user who performs the request is part of the middleware whitelist.

Request:
----------

.. code-block:: console

    curl --location --request GET 'https://demo.ddev.site/api/demo/photos/1' \
        --header 'Content-Type: application/json' \
        --header 'Accept: application/json' \
        --header 'Cookie: fe_typo_user=53574eb0bafe1c0a4d8a2cfc0cf726dd \
        --header 'X-CSRF-TOKEN: 53574eb0bafe1c0a4d8a2cfc0cf726dd'

Response:
----------

.. code-block:: json

    {
        "uid": 1,
        "pid": 0,
        "url": "https://via.placeholder.com/150/000000/FFFFFF/"
    }
