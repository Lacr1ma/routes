.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _error:

Possible errors
==================

.. rst-class:: bignums

1. My action is not executed and no errors in the response.

    **EXT:routes** does not throw all the errors back.

    It's a good idea to check the :file:`var/log/typo3_*.log` if your route has been mentioned in there.

2. LMS3\\Facade\\Extbase\\Plugin::getNameBasedOn() must be of type string, null returned.

    Check if plugin connected correctly. :ref:`See <demoplugin>`.

3. Class 'auth' not found

    Ensure TypoScript has been connected. :ref:`See <installation>`.
