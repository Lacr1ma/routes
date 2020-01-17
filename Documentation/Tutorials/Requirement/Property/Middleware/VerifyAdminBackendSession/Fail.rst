.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _VerifyAdminBackendSession_fail:

===================================
Example of failed request
===================================

.. rst-class:: bignums-xxl

1. When backend admin session does not exists.

    Request:

    .. code-block:: console

        curl --location --request GET 'https://demo.ddev.site/api/demo/photos/1' \
            --header 'Content-Type: application/json' \
            --header 'Accept: application/json' \
            --header 'Cookie: fe_typo_user=53574eb0bafe1c0a4d8a2cfc0cf726dd \
            --header 'X-CSRF-TOKEN: 53574eb0bafe1c0a4d8a2cfc0cf726dd'

    Response:

    .. code-block:: json

        {
            "error": "Admin user is required."
        }

2. When backend session exists, but request cookie (be_typo_user) is incorrect:

    Response:

    .. code-block:: json

        {
            "error": "BE session mismatch."
        }

.. warning::
      The response code will be **403**
