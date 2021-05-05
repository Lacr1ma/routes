.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _error:

Possible errors
==================

.. rst-class:: bignums

First of all you can check our example which we use for our test `suit <https://github.com/Lacr1ma/routes/tree/tests-v10/public/typo3conf/ext/demo>`__

1. My action is not executed and no errors in the response.

    **EXT:routes** does not throw all the errors back.

    It's a good idea to check the :file:`var/log/typo3_*.log` if your route has been mentioned in there.

2. LMS3\\Facade\\Extbase\\Plugin::getNameBasedOn() must be of type string, null returned.

    Check if plugin connected correctly. :ref:`See <demoplugin>`.

3. Class 'auth' not found

    Ensure TypoScript has been connected. :ref:`See <installation>`.

4. Response 404 - Page not found

    Ensure ApplyRoutesCollection has been included. `See <https://github.com/Lacr1ma/routes/issues/5>`__ .

5. ExtbaseRouteResolver middleware is never executed

    Ensure ApplyRoutesCollection has been included. `See <https://github.com/Lacr1ma/routes/issues/3>`__ .

6. Content-Type: text/html sent on subsequent requests

    We are not going to resolve this issue in a more convenient way, but **no_cache=1**
    might help you.
    `See <https://github.com/Lacr1ma/routes/issues/1>`__ .

7. If you use extensions like **staticfilecache** , ensure site root page is not cached!
