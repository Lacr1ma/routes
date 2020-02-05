.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _format:

Format
---------------

It's always a good idea to mention the format that route is working with.
It gives another developers a little bit of clarity when they read the route definition.
When format is set, that does not automatically mean we get the response of that format.
Format has impact only to *Extbase* action format, not to the response itself.
By default ( when not specified ) route applies *HTML* format.

.. tip::
   **Required**: No

   **Variants**: json | pdf | txt | print | rss | atom | html | any other...

.. code-block:: yaml
   :linenos:
   :emphasize-lines: 4

   demo_clients-show:
      path:         api/demo/clients/{uid}
      controller:   LMS\Demo\Controller\ClientApiController::show
      format:       html
      requirements:
         uid:       \d+
      defaults:
         plugin:    ClientApi

.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   Json
