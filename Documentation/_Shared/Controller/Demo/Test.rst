.. code-block:: php

    <?php
        declare(strict_types = 1);

        namespace LMS\Demo\Controller;

        use Psr\Http\Message\ResponseInterface;

        class DemoApiController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
        {
            public function testAction(): ResponseInterface
            {
                return $this->jsonResponse(
                    (string)json_encode(
                        'ok' => true
                    )
                );
            }
        }
