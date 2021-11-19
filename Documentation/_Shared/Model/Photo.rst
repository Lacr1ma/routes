.. code-block:: php

    <?php
        declare(strict_types = 1);

        namespace LMS\Demo\Domain\Model;

        class Photo extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
        {
            protected string $url = '';

            public function setUrl(string $url): void
            {
                $this->url = $url;
            }

            public function getUrl(): string
            {
                return $this->url;
            }
        }
