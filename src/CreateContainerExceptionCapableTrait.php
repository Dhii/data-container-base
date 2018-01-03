<?php

namespace Dhii\Data\Container;

use Dhii\Util\String\StringableInterface as Stringable;
use Dhii\Data\Container\Exception\ContainerException;
use Exception as RootException;

trait CreateContainerExceptionCapableTrait
{
    /**
     * Creates a new container exception.
     *
     * @param string|Stringable|null $message   The message for the exception, if any.
     * @param RootException|null     $previous  The inner exception, if any.
     * @param ContainerInterface     $container The problematic container, if any.
     *
     * @since [*next-version*]
     *
     * @return ContainerException The new exception.
     */
    protected function _createContainerException($message = null, RootException $previous = null, ContainerInterface $container = null)
    {
        return new ContainerException($message, 0, $previous, $container);
    }
}
