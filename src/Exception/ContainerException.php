<?php

namespace Dhii\Data\Container\Exception;

use Exception as RootException;
use Dhii\Data\Container\ContainerInterface;

/**
 * An exception that relates to a container.
 *
 * @since [*next-version*]
 */
class ContainerException extends AbstractContainerException implements ContainerExceptionInterface
{
    /**
     * @since [*next-version*]
     *
     * @param string             $message   The exception message.
     * @param int                $code      The exception code.
     * @param RootException      $previous  The inner exception, if any.
     * @param ContainerInterface $container The associated container, if any.
     */
    public function __construct($message = '', $code = 0, RootException $previous = null, ContainerInterface $container = null)
    {
        parent::__construct($message, $code, $previous);
        $this->_setContainer($container);

        $this->_construct();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getContainer()
    {
        return $this->_getContainer();
    }
}
