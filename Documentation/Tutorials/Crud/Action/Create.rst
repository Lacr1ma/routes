.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _action:

===================================
CREATE
===================================

.. rst-class:: bignums-xxl

#. Define appropriate route.

    .. include:: ../../../_Shared/Yaml/Photos/Store.rst

    .. tip::
        **store** action has been already implemented in our predefined controller.

        **POST** is not required, but as we follow the concept, we should always use it.

        **json** is not required, but it gives a little bit of clarity.

        **data** is required argument here, as we later pass data that will be placed inside *data* argument.

        **auth** FE user session is required as well as proper csrf token.

        **Throttle** It's optional, but quite useful. Usually we want to limit creation of certain recourse per time.

#. Use defined above endpoint in JavaScript scope.

    .. code-block:: javascript

        storeResource('/api/demo/photos', {title: 'My new entity'}).then(function (isOk) {
            console.log(isOk);
        });

.. tip::

    **storeResource** function has been already implemented in our predefined Routes.js.
