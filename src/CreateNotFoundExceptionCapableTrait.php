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
     * @param string|Stringable|null $message   The message for the exception, if any.
     * @param string|Stringable|null $dataKey   The data key, if any.
     * @param RootException|null     $previous  The inner exception, if any.
     * @param ContainerInterface     $container The problematic container, if any.
     *
     * @since [*next-version*]
     *
     * @return NotFoundException The new exception.
     */
    protected function _createNotFoundException($message = null, $dataKey = null, RootException $previous = null, ContainerInterface $container = null)
    {
        return new NotFoundException($message, 0, $previous, $container, $dataKey);
    }
}
