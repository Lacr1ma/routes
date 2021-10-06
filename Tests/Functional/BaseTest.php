<?php
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpRedundantCatchClauseInspection */
/** @noinspection PhpFullyQualifiedNameUsageInspection */

declare(strict_types = 1);

namespace LMS\Routes\Tests\Functional;

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

use LogicException;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Configuration\SiteConfiguration;
use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalResponse;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequestContext;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
abstract class BaseTest extends FunctionalTestCase
{
    protected const LANGUAGE_PRESETS = [
        'EN' => ['id' => 0, 'title' => 'English', 'locale' => 'en_US.UTF8', 'iso' => 'en', 'hrefLang' => 'en-US', 'direction' => ''],
    ];
    private const ENCRYPTION_KEY = '4408d27a916d51e624b69af3554f516dbab61037a9f7b9fd6f81b4d3bedeccb6';

    /**
     * @var array
     */
    protected $testExtensionsToLoad = ['typo3conf/ext/routes', 'typo3conf/ext/demo'];

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \TYPO3\TestingFramework\Core\Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        Bootstrap::initializeLanguageObject();

        $this->loadFixtures();
    }

    protected function writeSiteConfiguration(string $identifier, array $site = [], array $languages = [], array $errorHandling = []): void {
        $configuration = $site;
        if (!empty($languages)) {
            $configuration['languages'] = $languages;
        }
        if (!empty($errorHandling)) {
            $configuration['errorHandling'] = $errorHandling;
        }
        $siteConfiguration = new SiteConfiguration(
            $this->instancePath . '/typo3conf/sites/',
            $this->getContainer()->get('cache.core')
        );

        try {
            // ensure no previous site configuration influences the test
            GeneralUtility::rmdir($this->instancePath . '/typo3conf/sites/' . $identifier, true);
            $siteConfiguration->write($identifier, $configuration);
        } catch (Exception $exception) {
            $this->markTestSkipped($exception->getMessage());
        }
    }

    protected function buildSiteConfiguration(int $rootPageId, string $base = ''): array
    {
        return [
            'rootPageId' => $rootPageId,
            'base' => $base,
        ];
    }

    protected function buildDefaultLanguageConfiguration(string $identifier, string $base): array
    {
        $configuration = $this->buildLanguageConfiguration($identifier, $base);
        $configuration['typo3Language'] = 'default';
        $configuration['flag'] = 'global';
        unset($configuration['fallbackType'], $configuration['fallbacks']);
        return $configuration;
    }

    protected function resolveLanguagePreset(string $identifier): array
    {
        if (!isset(static::LANGUAGE_PRESETS[$identifier])) {
            throw new LogicException(
                sprintf('Undefined preset identifier "%s"', $identifier),
                1533893665
            );
        }
        return static::LANGUAGE_PRESETS[$identifier];
    }

    protected function buildLanguageConfiguration(string $identifier, string $base, array $fallbackIdentifiers = [], string $fallbackType = null): array
    {
        $preset = $this->resolveLanguagePreset($identifier);

        $configuration = [
            'languageId' => $preset['id'],
            'title' => $preset['title'],
            'navigationTitle' => $preset['title'],
            'base' => $base,
            'locale' => $preset['locale'],
            'iso-639-1' => $preset['iso'],
            'hreflang' => $preset['hrefLang'],
            'direction' => $preset['direction'],
            'typo3Language' => $preset['iso'],
            'flag' => $preset['iso'],
            'fallbackType' => $fallbackType ?? (empty($fallbackIdentifiers) ? 'strict' : 'fallback'),
        ];

        if (!empty($fallbackIdentifiers)) {
            $fallbackIds = array_map(
                function (string $fallbackIdentifier) {
                    $preset = $this->resolveLanguagePreset($fallbackIdentifier);
                    return $preset['id'];
                },
                $fallbackIdentifiers
            );
            $configuration['fallbackType'] = $fallbackType ?? 'fallback';
            $configuration['fallbacks'] = implode(',', $fallbackIds);
        }

        return $configuration;
    }

    private function setEnv(): void
    {
        $this->setUpFrontendRootPage(
            1,
            [
                'EXT:routes/Tests/Fixtures/Acceptance/root_page.typoscript'
            ]
        );

        $this->writeSiteConfiguration(
            'test',
            $this->buildSiteConfiguration(1, 'https://routes.ddev.site/'),
            [
                $this->buildDefaultLanguageConfiguration('EN', '/'),
            ]
        );
    }

    public function callEndpoint(string $slug, bool $withCsrf = true, bool $authenticated = true, bool $withBE = false, array $query = []): InternalResponse
    {
        $this->setEnv();

        $request = (new InternalRequest('https://routes.ddev.site/api/' . $slug))
            ->withPageId(1)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Accept', 'application/json')
            ->withQueryParameters($query);

        if ($withCsrf) {
            $csrf = FormProtectionFactory::get()
                ->generateToken('routes', 'api','1');

            $request = $request->withAddedHeader('X-CSRF-TOKEN', $csrf);
        }

        $settings = [
            'SYS' => [
                'encryptionKey' => self::ENCRYPTION_KEY,
            ]
        ];

        $context = (new InternalRequestContext())
            ->withGlobalSettings(['TYPO3_CONF_VARS' => $settings]);

        if ($authenticated) {
            $context = $context->withFrontendUserId(1);
        }

        if ($withBE) {
            $context = $context->withBackendUserId(1);
        }

        return $this->executeFrontendSubRequest($request, $context, true);
    }

    /**
     * @throws \TYPO3\TestingFramework\Core\Exception
     */
    protected function loadFixtures(): void
    {
        $this->importDataSet(__DIR__ . '/../Fixtures/Acceptance/pages.xml');
        $this->importDataSet(__DIR__ . '/../Fixtures/Acceptance/fe_users.xml');
        $this->importDataSet(__DIR__ . '/../Fixtures/Acceptance/fe_groups.xml');
        $this->importDataSet(__DIR__ . '/../Fixtures/Acceptance/sys_template.xml');
    }
}
