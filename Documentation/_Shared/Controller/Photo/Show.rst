.. code-block:: php

    <?php
        declare(strict_types = 1);

        namespace LMS\Demo\Controller;

        use LMS\Demo\Domain\Model\Photo;

        class PhotoApiController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
        {
            /**
            * @param \LMS\Demo\Domain\Model\Photo $photo
            * @return string
            */
            public function showAction(Photo $photo): string
            {
                return json_encode(
                    $photo->_getProperties()
                );
            }
        }
