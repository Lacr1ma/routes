.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _VerifyCsrfToken_given:

===================================
Preparation
===================================

Let's say we have a :file:`show` method that we want to trigger using the route.
We also have an intention to protect the route by **VerifyCsrfToken** middleware.

.. rst-class:: bignums-xxl

1. Define a route (Configuration/Routes.yml)

    .. code-block:: yaml
       :emphasize-lines: 13

       demo_photos-show:
         path:         api/demo/photos/{photo}
         controller:   LMS\Demo\Controller\PhotoApiController::show
         methods:      GET
         format:       json
         requirements:
           photo:      \d+
         defaults:
           plugin:     PhotoApi
           photo:
         options:
           middleware:
             - LMS\Routes\Middleware\Api\VerifyCsrfToken

2. Register Plugin namespace (ext_localconf.php)

    .. include:: ../../../../../_Shared/Plugin/PhotoApi/Show.rst

3. Create **photo** table (ext_tables.sql)

    .. include:: ../../../../../_Shared/Sql/photo.rst

4. Create entity TCA (Configuration/TCA/tx_demo_domain_model_photo.php)

    .. include:: ../../../../../_Shared/TCA/photo.rst

5. Create model (Classes/Domain/Model/Photo.php)

    .. include:: ../../../../../_Shared/Model/Photo.rst

6. Create Controller (Classes/Controller/PhotoApiController.php)

    .. include:: ../../../../../_Shared/Controller/Photo/Show.rst

.. tip::

    Of course, you can skip steps 3, 4, 5 if you are not dealing with models.
