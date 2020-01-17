.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _authenticate_fail:

===================================
Example of failed request
===================================

When user sends an unauthorized request, we probably face the error.

.. rst-class:: bignums-xxl

1. Request expects JSON format

    Request:

    .. code-block:: console

        curl --location --request GET 'https://demo.ddev.site/api/demo/photos/1' \
            --header 'Accept: application/json'

    Response:

    .. code-block:: json

        {
            "error": "Authentication required."
        }

    .. warning::
          The response code will be **401**

2. Request expects HTML format

    Request:

    .. code-block:: console

        curl --location --request GET 'https://demo.ddev.site/api/demo/photos/1'

    In that case you will not get the error message, instead the request just forwarded to the login page.

.. tip::
      **plugin.tx_routes.settings.redirect.loginPage** should be set to reflect the login page.
