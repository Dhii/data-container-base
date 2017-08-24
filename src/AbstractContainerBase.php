<?php

namespace Dhii\Data\Container;

use Exception as RootException;
use Dhii\Data\Container\Exception\ContainerException;
use Dhii\Data\Container\Exception\NotFoundException;

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
     * @since [*next-version*]
     */
    protected function _createContainerException($message = null, RootException $previous = null)
    {
        return new ContainerException($message, 0, $previous, $this);
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _createNotFoundException($message = null, $dataKey = null, RootException $previous = null)
    {
        return new NotFoundException($message, 0, $previous, $this, $dataKey);
    }
}
