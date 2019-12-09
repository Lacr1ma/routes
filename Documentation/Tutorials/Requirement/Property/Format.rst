.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _property:

===================================
Format
===================================

.. code-block:: yaml
   :linenos:
   :emphasize-lines: 4

   demo_remove:
      path:         clients/{client}
      controller:   LMS\Demo\Controller\DemoApiController::test
      format:       json

.. tip::
   **Required**: No

   **Variants**: json | pdf | txt | print | rss | atom | any other...

.. tip::
      By default ( when methods is not specified ) we use default system value which is *html*

Example
===================================

.. code-block:: yaml
   :linenos:

    my_example:
      path:         api/demo/test
      controller:   LMS\Demo\Controller\DemoApiController::test
      format:       json

.. tip::
   1. :file:`EXT:demo/View/DemoApi/TestJson.php`: expected to be in place.

.. code-block:: php

   namespace LMS\Demo\View\DemoApi;

   class TestJson extends \TYPO3\CMS\Extbase\Mvc\View\AbstractView
   {
       public function render()
       {
           return json_encode(['ok' => true]);
       }
   }

.. tip::
   2. Or alternatively, :file:`EXT:demo/Resources/Private/Templates/DemoApi/Test.json`: expected to be in place.
   In this case **$defaultViewObjectName** should not be overwritten.

.. code-block:: html

   {
     "status": "ok"
   }

