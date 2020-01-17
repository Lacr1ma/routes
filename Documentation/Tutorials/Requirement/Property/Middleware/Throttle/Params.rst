.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _Throttle_params:

===================================
Throttle Middleware Parameters
===================================

.. code-block:: yaml

    extension_controller-action:
        middleware:
            - LMS\Routes\Middleware\Api\Throttle:10,1

**Throttle:10,1** can be interpreted as follows:

Allow route to be executed 10 times per 1 minute.

Properties
^^^^^^^^^^

.. container:: ts-properties

	==================================== ====================================== ===============
	Property                             Title                                  Type
	==================================== ====================================== ===============
	first                                 Allowed count of calls                int
	second                                Decay interval in minutes             int
	==================================== ====================================== ===============
