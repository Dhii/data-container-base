<?php

namespace Dhii\Data\Container;

use Exception as RootException;
use Dhii\Data\Container\Exception\ContainerException;
use Dhii\Data\Container\Exception\NotFoundException;
use Dhii\Util\String\StringableInterface as Stringable;

/**
 * Base concrete functionality for containers.
 *
 * @since [*next-version*]
 */
abstract class AbstractContainerBase implements ContainerInterface
{
    /**
     * Creates a new container exception.
     *
     * @param string|Stringable|null $message  The message for the exception, if any.
     * @param RootException|null     $previous The inner exception, if any.
     *
     * @since [*next-version*]
     *
     * @return ContainerException The new exception.
     */
    protected function _createContainerException($message = null, RootException $previous = null)
    {
        return new ContainerException($message, 0, $previous, $this);
    }

    /**
     * Creates a new not found exception.
     *
     * @param string|Stringable|null $message  The message for the exception, if any.
     * @param string|Stringable|null $dataKey  The data key, if any.
     * @param RootException|null     $previous The inner exception, if any.
     *
     * @since [*next-version*]
     *
     * @return NotFoundException The new exception.
     */
    protected function _createNotFoundException($message = null, $dataKey = null, RootException $previous = null)
    {
        return new NotFoundException($message, 0, $previous, $this, $dataKey);
    }
}
