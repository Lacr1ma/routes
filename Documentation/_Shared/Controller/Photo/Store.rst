.. code-block:: php

    <?php
        declare(strict_types = 1);

        namespace LMS\Demo\Controller;

        use LMS\Demo\Domain\Model\Photo;

        class PhotoApiController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
        {
            /**
            * @param string $url
            * @return string
            */
            public function storeAction(string $url): string
            {
                $created = (bool)Photo::create(compact('url'));

                return json_encode(compact('created');
            }
        }
