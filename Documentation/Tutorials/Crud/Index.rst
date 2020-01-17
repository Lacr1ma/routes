.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. _crud:

Preparation
---------------

.. rst-class:: bignums-xxl

#. Define appropriate route.

   Create your route collection file under :file:`Configuration/Routes.yml`:

#. Your Resource repository must extend our predefined **AbstractRepository**.

   Create your repository under :file:`Classes/Domain/Repository/EntityRepository.php`:

   .. code-block:: php

      <?php
         declare(strict_types = 1);

         namespace Vendor\Demo\Domain\Repository;

         class EntityRepository extends \LMS\Facade\Repository\AbstractRepository
         {
            // ...
         }

   .. tip::

        **EntityRepository** replace with your real repository name.

#. Create your own **JsonView**.

   Create your view under :file:`Classes/Mvc/View/JsonView.php`:

   .. code-block:: php

      <?php
         declare(strict_types = 1);

         namespace Vendor\Demo\Mvc\View;

         class JsonView extends \LMS\Facade\Mvc\View\JsonView
         {
             /**
              * @var array
              */
             protected $configuration = [
                 'entity' => [
                     '_descendAll' => [
                         '_exclude' => ['pid']
                     ]
                 ]
             ];
         }

   .. tip::

         **getRootName** should return the name of your resource.
         In this case it's **entity**
         Don't forget to rename it with your real name.

#. Your Controller must extend our predefined **AbstractApiController**.

   Create your view under :file:`Classes/Controller/DemoApiController.php`:

   .. code-block:: php

      <?php
         declare(strict_types = 1);

         namespace Vendor\Demo\Controller;

         class DemoApiController extends \LMS\Facade\Controller\AbstractApiController
         {
            /**
              * @var string
              */
             public $defaultViewObjectName = \Vendor\Demo\Mvc\View\JsonView::class;

            /**
              * {@inheritdoc}
              */
             protected function getRootName(): string
             {
                 return 'entity';
             }

             /**
               * {@inheritdoc}
               */
              protected function getResourceRepository(): RepositoryInterface
              {
                  return EntityRepository::make();
              }
         }

   #. **AbstractApiController**
      Predefined controller that implements all needed CRUD actions.
      It also uses JSON view instead of standard one, that's pretty much what you want
      when dealing with API.

   #. **getResourceRepository**
      ApiController needs to know which resource it's connected to.
      So you need to return the actual Resource repository.
      Before, you have already extended your fresh repository from our predefined **AbstractRepository**
      so *make()* is available for making a fresh instance of it.

   #. **getRootName**
      Connected to Response that you get. This is actually the root name of your response data.
      We could use the default one, but current approach gives you a possibility to manipulate data
      using *JsonView*

   .. tip::
         **defaultViewObjectName** is connected to your JsonView.

CRUD
---------------

   #. Represents the route name. It should be unique. Name could be used in **MakeSlugViewHelper** on demand.
   #. :yaml:`path` is the route you expect to see as an API endpoint. Later you need to use this url to perform the request.
   #. :yaml:`controller` Indicates which Extbase Controller and action inside it should be triggered during the request.
   #. :yaml:`methods` Specifies which request type is granted to call the action ( could be more than just one).
   #. :yaml:`schemes` Which protocol should be used during the request.
   #. :yaml:`format` Indicates which view format we deal with. By default Extbase will trigger MyView.html, if it is set to json, the result will be MyView.json
   #. :yaml:`defaults` This is a container that may contain predefined values for your action, so-called arguments.
   #. :yaml:`data` Required when we pass any data using POST or PUT methods. Just keep it empty for those methods.
   #. :yaml:`requirements` Allow us to control the variable type for dynamic variable in the route.
   #. :yaml:`middleware` Allow us to call certain list of middleware for the route.

   .. code-block:: yaml

      extension_controller-action:
         path:         api/path/to/my/route/{entity}
         controller:   Vendor\Demo\Controller\DemoApiController::myActionName
         methods:      [GET, POST, PUT, DELETE]
         schemes:      [https, http]
         format:       json
         defaults:
            data:
         requirements:
            entity:    \d+
         options:
            middleware:
               - auth
               - LMS\Routes\Middleware\Api\VerifyAdminBackendSession
               - Vendor\Demo\Middleware\Api\MyMiddleware

.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

   Action/Create
   Action/Read
   Action/Update
   Action/Delete
   Action/List
