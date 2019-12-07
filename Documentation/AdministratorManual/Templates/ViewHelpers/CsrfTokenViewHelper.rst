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

Output: ::

	 1f4d3b99ae2d29bbf5a6ce3a6dfc2ce7

.. tip::
      Each FE use has it's own csrf token. In general, it's just a session id that changes during the time.
