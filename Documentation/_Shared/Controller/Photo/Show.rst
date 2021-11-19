.. code-block:: php

    <?php
        declare(strict_types = 1);

        namespace LMS\Demo\Controller;

        use LMS\Demo\Domain\Model\Photo;
        use Psr\Http\Message\ResponseInterface;

        class PhotoApiController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
        {
            public function showAction(Photo $photo): ResponseInterface
            {
                return $this->jsonResponse(
                    (string)json_encode(
                        $photo->_getProperties()
                    )
                );
            }
        }
