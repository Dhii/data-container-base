<?php

namespace Dhii\Data\Container;

use Exception as RootException;
use InvalidArgumentException;

/**
 * Functionality for retrieval of a container.
 *
 * @since [*next-version*]
 */
trait ContainerAwareTrait
{
    /**
     * The container.
     *
     * @since [*next-version*]
     *
     * @var ContainerInterface|null
     */
    protected $container;

    /**
     * Retrieves the container associated with this instance.
     *
     * @since [*next-version*]
     *
     * @return ContainerInterface|null The container, if any.
     */
    protected function _getContainer()
    {
        return $this->container;
    }

    /**
     * Associates a container with this instance.
     *
     * @since [*next-version*]
     *
     * @param ContainerInterface|null $container The container.
     *
     * @throws InvalidArgumentException If not a valid container.
     */
    protected function _setContainer($container)
    {
        if (!is_null($container) && !($container instanceof ContainerInterface)) {
            throw $this->_createInvalidArgumentException($this->__('Not a valid container'), 0, null, $container);
        }

        $this->container = $container;

        return $this;
    }

    /**
     * Creates a new Dhii invalid argument exception.
     *
     * @since [*next-version*]
     *
     * @param string        $message  The error message.
     * @param int           $code     The error code.
     * @param RootException $previous The inner exception for chaining, if any.
     * @param mixed         $argument The invalid argument, if any.
     *
     * @return InvalidArgumentException The new exception.
     */
    abstract protected function _createInvalidArgumentException(
            $message = '',
            $code = 0,
            RootException $previous = null,
            $argument = null
    );

    /**
     * Translates a string, and replaces placeholders.
     *
     * @since [*next-version*]
     * @see sprintf()
     *
     * @param string $string  The format string to translate.
     * @param array  $args    Placeholder values to replace in the string.
     * @param mixed  $context The context for translation.
     *
     * @return string The translated string.
     */
    abstract protected function __($string, $args = array(), $context = null);
}