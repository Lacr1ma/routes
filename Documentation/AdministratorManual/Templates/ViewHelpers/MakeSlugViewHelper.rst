.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _viewHelpers

MakeSlugViewHelper
----------------------

ViewHelper to render slug for requested route

Properties
^^^^^^^^^^^^^^^^^^^^^^^

.. t3-field-list-table::
 :header-rows: 1

 - :Name: Name:
   :Type: Type:
   :Description: Description:

 - :Name:
         for
   :Type:
         string
   :Description:
         Route name


 - :Name:
         with
   :Type:
         array
   :Description:
         Route parameters

Example
^^^^^^^^^^^^^

.. code-block:: yaml

      demo_clients-show:
         path:       api/demo/clients/{client}
         controller: Vendor\Demo\Controller\ClientApiController::show

.. code-block:: html

   {namespace route = LMS\Routes\ViewHelpers}

   <a href="{route:makeSlug( for: 'demo_clients-show', with: {client: 2} )}">
      Show
   </a>

   // or initialize a JS constant
   <script type="text/javascript">
      const showClientUrl = "{route:makeSlug( for: 'demo_clients-show', with: {client: 2} )}";
   </script>

Output: ::

   api/demo/clients/2

.. code-block:: javascript

   readResource(showClientUrl).then(function (client) {
      console.log(client);
   });
