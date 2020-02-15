.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _property:

===================================
Host
===================================

Routes can configure a host option to require that the HTTP host of the incoming requests matches some specific value.
In the following example, both routes match the same path (/) but one of them only responds to a specific host name.

.. code-block:: yaml
   :linenos:
   :emphasize-lines: 3

   demo_home-mobile:
      path:         /
      host:         m.demo.ddev.site
      controller:   LMS\Demo\Controller\HomePageController::mobile


   demo_home-desktop:
      path:         /
      controller:   LMS\Demo\Controller\HomePageController::desktop

.. tip::
   **Required**: No


The value of the host option can include parameters (which is useful in multi-tenant applications)
and these parameters can be validated too with requirements.

.. code-block:: yaml
   :linenos:

   demo_home-mobile:
      path:         /
      host:         "{subdomain}.demo.ddev.site"
      controller:   LMS\Demo\Controller\HomePageController::mobile
      defaults:
        subdomain:  m
      requirements:
        subdomain:  m|mobile

   demo_home-desktop:
      path:         /
      controller:   LMS\Demo\Controller\HomePageController::desktop

In the above example, the subdomain parameter defines a default value because otherwise you need to include a domain value each time you generate a URL using these routes.
