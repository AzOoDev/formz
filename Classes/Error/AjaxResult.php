<?php
/*
 * 2017 Romain CANON <romain.hydrocanon@gmail.com>
 *
 * This file is part of the TYPO3 FormZ project.
 * It is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License, either
 * version 3 of the License, or any later version.
 *
 * For the full copyright and license information, see:
 * http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Romm\Formz\Error;

use Romm\Formz\Service\Traits\StoreDataTrait;
use TYPO3\CMS\Extbase\Error\Result;

/**
 * Result instance used by the Ajax validation controller.
 */
class AjaxResult extends Result
{
    use StoreDataTrait;
}
