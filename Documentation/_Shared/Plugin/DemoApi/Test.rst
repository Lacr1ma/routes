.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _demoplugin:

.. code-block:: php

    use Vendor\Demo\Controller\DemoApiController;

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Demo',
        'DemoApi',
        [
            DemoApiController::class => 'test'
        ],
        [
            DemoApiController::class => 'test'
        ]
    );
