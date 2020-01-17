.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _Throttle_success:

===================================
Example of success request
===================================

If request is not throttled

Request:
----------

.. code-block:: console

    curl --location --request POST 'https://demo.ddev.site/api/demo/photos' \
        --header 'Content-Type: application/json' \
        --header 'Accept: application/json' \
        --header 'Cookie: fe_typo_user=53574eb0bafe1c0a4d8a2cfc0cf726dd \
        --header 'X-CSRF-TOKEN: 53574eb0bafe1c0a4d8a2cfc0cf726dd' \
        --form 'url=https://dummyimage.com/600x400/000/fff'

Response:
----------

.. code-block:: json

    {
        "created": true
    }
