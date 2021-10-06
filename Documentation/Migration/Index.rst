.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _migration:

Migration
============

1.x.x to 2.x.x
---------------

.. rst-class:: bignums-xxl

#. Add new route enhancer in your site configuration.

   .. code-block:: yaml

      routeEnhancers:
        ApplyRoutesCollection:
          type: Routes

#. Add plugin name to all your route definition ( if it's not there ).

   .. code-block:: yaml
      :linenos:
      :emphasize-lines: 4,5

         demo_photos-all:
            path:         api/demo/photos
            controller:   LMS\Demo\Controller\PhotoApiController::all
            defaults:
              plugin:     PhotoApi

   .. tip::

        Before 2.x, plugin was discovered by extension itself. Since TYPO3 v10
        this does not work anymore.

#. Replace **$_EXTKEY** by extension name itself.

   .. code-block:: php
      :linenos:
      :emphasize-lines: 3

      // Now...
      \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
          'LMS.demo',
          '',
          [],
          []
      );

   .. code-block:: php
     :linenos:
     :emphasize-lines: 3

      // Before...
      \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
          'LMS.' . $_EXTKEY,
          '',
          [],
          []
      );
