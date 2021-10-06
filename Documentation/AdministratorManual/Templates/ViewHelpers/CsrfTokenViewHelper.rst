.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _viewHelpers

CsrfTokenViewHelper
-----------------------------------

ViewHelper that renders CSRF Token in the template.
Allows you to use it in your forms and pass it to the JS if needed.

Example
^^^^^^^^^^^^^

.. code-block:: html

   {namespace route = LMS\Routes\ViewHelpers}

   <route:csrfToken />