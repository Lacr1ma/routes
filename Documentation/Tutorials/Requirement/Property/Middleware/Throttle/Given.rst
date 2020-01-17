.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _Throttle_given:

===================================
Preparation
===================================

Let's say we have the :file:`store` method which creates a photo.

We also have an intention to protect the route by **Throttle** middleware.

.. rst-class:: bignums-xxl

1. Define a route (Configuration/Routes.yml)

    .. code-block:: yaml
      :emphasize-lines: 13

      demo_photos-store:
        path:         api/demo/photos
        controller:   Vendor\Demo\Controller\PhotoApiController::store
        methods:      POST
        format:       json
        requirements:
          url:
        defaults:
          url:
        options:
          middleware:
            - auth
            - LMS\Routes\Middleware\Api\Throttle:10,1

2. Register Plugin namespace (ext_localconf.php)

    .. include:: ../../../../../_Shared/Plugin/PhotoApi/Store.rst

3. Create **photo** table (ext_tables.sql)

    .. include:: ../../../../../_Shared/Sql/photo.rst

4. Create TCA (Configuration/TCA/tx_demo_domain_model_photo.php)

    .. include:: ../../../../../_Shared/TCA/photo.rst

5. Create model (Classes/Domain/Model/Photo.php)

   .. include:: ../../../../../_Shared/Model/Photo.rst

6. Create a repository (Classes/Domain/Repository/PhotoRepository.php)

    .. include:: ../../../../../_Shared/Repository/Photo.rst

7. Create Controller (Classes/Controller/PhotoApiController.php)

    .. include:: ../../../../../_Shared/Controller/Photo/Store.rst

.. tip::

    Steps 3, 4, 5, 6 are required only if you deal with a model.
