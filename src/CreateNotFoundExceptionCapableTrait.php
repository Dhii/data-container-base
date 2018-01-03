<?php

namespace Dhii\Data\Container;

use Dhii\Util\String\StringableInterface as Stringable;
use Dhii\Data\Container\Exception\NotFoundException;
use Exception as RootException;

trait CreateNotFoundExceptionCapableTrait
{
    /**
     * Creates a new not found exception.
     *
     * @param string|Stringable|null     $message   The exception message, if any.
     * @param int|string|Stringable|null $code      The numeric exception code, if any.
     * @param RootException|null         $previous  The inner exception, if any.
     * @param ContainerInterface|null    $container The associated container, if any.
     * @param string|Stringable|null     $dataKey   The missing data key, if any.
     *
     * @since [*next-version*]
     *
     * @return NotFoundException The new exception.
     */
    protected function _createNotFoundException(
        $message = null,
        $code = null,
        RootException $previous = null,
        ContainerInterface $container = null,
        $dataKey = null
    ) {
        return new NotFoundException($message, $code, $previous, $container, $dataKey);
    }
}
