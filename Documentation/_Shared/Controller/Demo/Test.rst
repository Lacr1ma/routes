.. code-block:: php

    <?php
        declare(strict_types = 1);

        namespace LMS\Demo\Controller;

        class DemoApiController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
        {
            /**
            * @return string
            */
            public function testAction(): string
            {
                return json_encode(
                    'ok' => true
                );
            }
        }
