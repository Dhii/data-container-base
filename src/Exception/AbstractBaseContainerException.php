<?php

namespace Dhii\Data\Container\Exception;

use Exception as RootException;
use Dhii\I18n\StringTranslatingTrait;
use Dhii\Exception\CreateInvalidArgumentExceptionCapableTrait;
use Dhii\Data\Container\ContainerAwareTrait;

/**
 * Common functionality for container exceptions.
 *
 * @since [*next-version*]
 */
abstract class AbstractBaseContainerException extends RootException
{
    /*
     * Adds string translation functionality.
     *
     * @since [*next-version*]
     */
    use StringTranslatingTrait;

    /*
     * Adds exception-creating factory.
     *
     * @since [*next-version*]
     */
    use CreateInvalidArgumentExceptionCapableTrait;

    /*
     * Adds container awareness.
     *
     * @since [*next-version*]
     */
    use ContainerAwareTrait;

    /**
     * Parameter-less constructor.
     *
     * Invoke this in the actual constructor.
     *
     * @since [*next-version*]
     */
    protected function _construct()
    {
    }
}
