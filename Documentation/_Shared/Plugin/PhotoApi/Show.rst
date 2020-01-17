.. code-block:: php

   \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
       'LMS.' . $_EXTKEY,
       'PhotoApi',
       [
           'PhotoApi' => 'show'
       ],
       [
           'PhotoApi' => 'show'
       ]
   );

.. tip::

    Plugin registration in
    :file:`Configuration/TCA/Overrides/tt_content.php` is optional.
