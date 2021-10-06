<?php
/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types = 1);

namespace LMS\Routes\Middleware\Api;

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

use TYPO3\CMS\Core\Registry;
use LMS\Routes\Support\User;
use LMS\Routes\Support\Redirect;
use LMS\Routes\Support\Response;
use LMS\Routes\Support\Throttler;
use LMS\Routes\Support\TypoScript;
use TYPO3\CMS\Core\Context\Context;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
abstract class AbstractRouteMiddleware
{
    protected User $user;
    protected TypoScript $ts;
    protected array $properties;
    protected Response $response;
    protected Registry $registry;
    protected Redirect $redirect;
    protected Throttler $throttler;
    protected ServerRequestInterface $request;

    public function __construct(Context $ctx, Registry $registry, User $user, Response $response, Redirect $redirect, TypoScript $ts, Throttler $throttler)
    {
        $this->ts = $ts;
        $this->user = $user;
        $this->registry = $registry;
        $this->response = $response;
        $this->redirect = $redirect;
        $this->throttler = $throttler;

        $authUid = (int)$ctx
            ->getPropertyFromAspect('frontend.user', 'id');

        $this->user->setUser($authUid);
    }

    public function setRequest(ServerRequestInterface $request): void
    {
        $this->request = $request;
    }

    public function setProperties(array $properties): void
    {
        $this->properties = $properties;
    }

    /**
     * @throws MethodNotAllowedException
     * @throws PropagateResponseException
     */
    abstract public function process(): void;

    /**
     * @throws MethodNotAllowedException
     */
    protected function deny(string $message, int $status = 200): void
    {
        throw new MethodNotAllowedException([], $message, $status);
    }

    protected function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }

    protected function getProperties(): array
    {
        return $this->properties;
    }

    public function getOriginalParams(): array
    {
        return (array)$this->getRequest()->getAttributes()['_originalGetParameters'];
    }

    public function getQuery(): array
    {
        return $this->getRequest()->getQueryParams();
    }

    protected function getAdminExtensionName(): string
    {
        $props = $this->getProperties();

        $extKey = (string)array_pop($props);

        return $extKey ?: 'tx_routes';
    }

    protected function getSettings(string $extKey): array
    {
        return $this->ts->getSettings($extKey);
    }
}
