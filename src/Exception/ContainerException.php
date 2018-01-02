<?php

namespace Dhii\Data\Container\Exception;

use Exception as RootException;
use Dhii\Data\Container\ContainerInterface;
use Dhii\Util\String\StringableInterface as Stringable;

/**
 * An exception that relates to a container.
 *
 * @since [*next-version*]
 */
class ContainerException extends AbstractBaseContainerException implements ContainerExceptionInterface
{
    /**
     * @since [*next-version*]
     *
     * @param string|Stringable|null  $message   The exception message, if any.
     * @param int                     $code      The exception code.
     * @param RootException|null      $previous  The inner exception, if any.
     * @param ContainerInterface|null $container The associated container, if any.
     */
    public function __construct($message = '', $code = 0, RootException $previous = null, ContainerInterface $container = null)
    {
        parent::__construct((string) $message, $code, $previous);
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
