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

namespace Romm\Formz\Exceptions;

use Romm\Formz\Middleware\Item\AbstractMiddleware;
use Romm\Formz\Middleware\Signal\SendsMiddlewareSignal;

class InvalidEntryException extends FormzException
{
    const INVALID_CSS_CLASS_NAMESPACE = 'The class "%s" is not valid: the namespace of the error must be one of the following: %s.';

    const MIDDLEWARE_NOT_SENDING_SIGNALS = 'The middleware "%s" does not implement interface "%s", therefore it can not dispatch signals.';

    /**
     * @code 1467623504
     *
     * @param string $className
     * @param array  $acceptedClassesNameSpace
     * @return self
     */
    final public static function invalidCssClassNamespace($className, array $acceptedClassesNameSpace)
    {
        /** @var self $exception */
        $exception = self::getNewExceptionInstance(
            self::INVALID_CSS_CLASS_NAMESPACE,
            [$className, implode(', ', $acceptedClassesNameSpace)]
        );

        return $exception;
    }

    /**
     * @code 1490798324
     *
     * @param AbstractMiddleware $middleware
     * @return InvalidEntryException
     */
    final public static function middlewareNotSendingSignals(AbstractMiddleware $middleware)
    {
        /** @var self $exception */
        $exception = self::getNewExceptionInstance(
            self::MIDDLEWARE_NOT_SENDING_SIGNALS,
            [get_class($middleware), SendsMiddlewareSignal::class]
        );

        return $exception;
    }
}
