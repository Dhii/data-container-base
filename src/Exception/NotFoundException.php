<?php

namespace Dhii\Data\Container\Exception;

use Exception as RootException;
use Dhii\Data\Container\ContainerInterface;
use Dhii\Data\Container\DataKeyAwareTrait;
use Dhii\Util\String\StringableInterface as Stringable;

/**
 * An exception that relates to a container.
 *
 * @since [*next-version*]
 */
class NotFoundException extends AbstractBaseContainerException implements NotFoundExceptionInterface
{
    /*
     * Adds data key awareness.
     *
     * @since [*next-version*]
     */
    use DataKeyAwareTrait;

    /**
     * @since [*next-version*]
     *
     * @param string|Stringable|null  $message   The exception message, if any.
     * @param int                $code      The exception code.
     * @param RootException|null      $previous  The inner exception, if any.
     * @param ContainerInterface|null $container The associated container, if any.
     * @param string|Stringable|null  $dataKey   The missing data key, if any.
     */
    public function __construct($message = '', $code = 0, RootException $previous = null, ContainerInterface $container = null, $dataKey = null)
    {
        parent::__construct((string) $message, $code, $previous);
        $this->_setContainer($container);
        $this->_setDataKey($dataKey);

        $this->_construct();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getDataKey()
    {
        return $this->_getDataKey();
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
