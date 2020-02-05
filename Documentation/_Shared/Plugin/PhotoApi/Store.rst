.. code-block:: php

   \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
       'LMS.demo',
       'PhotoApi',
       [
           'PhotoApi' => 'store'
       ],
       [
           'PhotoApi' => 'store'
       ]
   );

.. tip::

    Plugin registration in
    :file:`Configuration/TCA/Overrides/tt_content.php` is optional.
