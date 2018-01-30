<?php

namespace Dhii\Data\Container\Exception;

use Exception as RootException;
use Dhii\Util\String\StringableInterface as Stringable;
use Psr\Container\ContainerInterface;

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
     * @param string|Stringable|null     $message   The exception message, if any.
     * @param int|string|Stringable|null $code      The numeric exception code, if any.
     * @param RootException|null         $previous  The inner exception, if any.
     * @param ContainerInterface|null    $container The associated container, if any.
     */
    public function __construct($message = null, $code = null, RootException $previous = null, ContainerInterface $container = null)
    {
        $message = is_null($message)
            ? $message
            : $this->_normalizeString($message);

        $code = is_null($code)
            ? $code
            : $this->_normalizeInt($code);

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
