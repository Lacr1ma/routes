.. code-block:: php

    use Vendor\Demo\Controller\PhotoApiController;

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Demo',
        'PhotoApi',
        [
            PhotoApiController::class => 'store'
        ],
        [
            PhotoApiController::class => 'store'
        ]
    );

.. tip::

    Plugin registration in
    :file:`Configuration/TCA/Overrides/tt_content.php` is optional.
