<?php
declare(strict_types = 1);

namespace LMS\Routes\Support;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\ResponseFactory;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class Redirect
{
    private UriBuilder $uri;
    private ResponseFactory $factory;

    public function __construct(ResponseFactory $factory, UriBuilder $uri)
    {
        $this->factory = $factory;
        $this->uri = $uri->reset();
    }

    public function toPage(int $pid): ResponseInterface
    {
        $url = $this->uriFor($pid);

        return $this->toUri($url);
    }

    public function toUri(string $uri, int $status = 303): ResponseInterface
    {
        $response = $this->factory->createResponse($status);

        return $response->withAddedHeader('location', $uri);
    }

    public function uriFor(int $pid, bool $absolute = false): string
    {
        return $this->uri
            ->setLinkAccessRestrictedPages(true)
            ->setCreateAbsoluteUri($absolute)
            ->setTargetPageUid($pid)
            ->build();
    }

    public function factory(): ResponseFactory
    {
        return $this->factory;
    }

    public function uriBuilder(): UriBuilder
    {
        return $this->uri;
    }
}
