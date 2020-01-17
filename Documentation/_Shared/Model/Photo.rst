.. code-block:: php

    <?php
        declare(strict_types = 1);

        namespace LMS\Demo\Domain\Model;

        class Photo extends \LMS\Facade\Model\AbstractModel
        {
            /**
             * @var string
             */
            protected $url;

            /**
             * @param string $url
             */
            public function setUrl(string $url): void
            {
                $this->url = $url;
            }

            /**
             * @return string
             */
            public function getUrl(): string
            {
                return $this->url;
            }
        }
