<?php
declare(strict_types = 1);

namespace LMS\Routes\ViewHelpers;

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

use LMS\Routes\Service\Router;

/**
 * @author Borulko Sergey <borulkosergey@icloud.com>
 */
class MakeSlugViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    use Router;

    /**
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('for', 'string', 'The name of the route', true);
        $this->registerArgument('with', 'array', 'Optional route parameters', false, []);
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $name = $this->arguments['for'];
        $arguments = $this->arguments['with'];

        return $this->getRouter()->generate($name, $arguments);
    }
}
