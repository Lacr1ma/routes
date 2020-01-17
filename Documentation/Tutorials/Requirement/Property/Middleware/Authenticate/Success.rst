.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _authenticate_success:

===================================
Example of success request
===================================

If everything is fine and our user is authorized, we should see the next picture.

Request:
----------

.. code-block:: console

    curl --location --request GET 'https://demo.ddev.site/api/demo/photos/1' \
        --header 'Content-Type: application/json' \
        --header 'Accept: application/json' \
        --header 'Cookie: fe_typo_user=53574eb0bafe1c0a4d8a2cfc0cf726dd

Response:
----------

.. code-block:: json

    {
        "uid": 1,
        "pid": 0,
        "url": "https://via.placeholder.com/150/000000/FFFFFF/"
    }
