<?php

namespace Dhii\Data\Container\FuncTest\Exception;

use Xpmock\TestCase;
use Dhii\Data\Container\Exception\AbstractBaseContainerException as TestSubject;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class AbstractBaseContainerExceptionTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Data\Container\Exception\AbstractBaseContainerException';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return TestSubject The new instance of the test subject.
     */
    public function createInstance($message = '', $code = 0, $previous = null, $container = null)
    {
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
                ->new($message, $code, $previous);

        return $mock;
    }

    /**
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance();

        $this->assertInstanceOf(self::TEST_SUBJECT_CLASSNAME, $subject, 'A valid instance of the test subject could not be created');
    }
}
