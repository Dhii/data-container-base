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
     * {@inheritdoc}
     *
     * @param string|Stringable|null $message The message for the exception, if any.
     * @param RootException $previous The inner exception, if any.
     *
     * @since [*next-version*]
     */
    protected function _createContainerException($message = null, RootException $previous = null)
    {
        return new ContainerException($message, 0, $previous, $this);
    }

    /**
     * {@inheritdoc}
     *
     * @param string|Stringable|null $message The message for the exception, if any.
     * @param string|Stringable|null $dataKey The data key, if any.
     * @param RootException $previous The inner exception, if any.
     *
     * @since [*next-version*]
     */
    protected function _createNotFoundException($message = null, $dataKey = null, RootException $previous = null)
    {
        return new NotFoundException($message, 0, $previous, $this, $dataKey);
    }
}
