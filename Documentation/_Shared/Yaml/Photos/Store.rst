.. code-block:: yaml

  demo_photos-store:
    path:         api/demo/photos
    controller:   Vendor\Demo\Controller\PhotoApiController::store
    methods:      POST
    format:       json
    defaults:
      plugin:     PhotoApi
      data:
    options:
      middleware:
        - auth
        - LMS\Routes\Middleware\Api\Throttle:10,1
