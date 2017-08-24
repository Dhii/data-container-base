<?php

namespace Dhii\Data\Container\FuncTest\Exception;

use Xpmock\TestCase;
use Exception as RootException;
use Dhii\Data\Container\Exception\ContainerException as TestSubject;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class ContainerExceptionTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Data\Container\Exception\ContainerException';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return TestSubject The new instance of the test subject.
     */
    public function createInstance($message = null, $code = 0, $previous = null, $container = null)
    {
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
                ->new($message, $code, $previous, $container);

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

    /**
     * Creates a new exception.
     *
     * @since [*next-version*]
     *
     * @param string        $message
     * @param int           $code
     * @param RootException $previous
     *
     * @return RootException The new exception.
     */
    public function createException($message = null, $code = null, RootException $previous = null)
    {
        return new \Exception($message, $code, $previous);
    }

    /**
     * Creates a new container.
     *
     * @since [*next-version*]
     *
     * @return \Dhii\Data\Container\ContainerInterface The new instance of the test subject.
     */
    public function createContainer()
    {
        $container = $this->mock('Dhii\Data\Container\ContainerInterface')
                ->has()
                ->get()
                ->new();

        return $container;
    }

    /**
     * Tests that a container exception can be created correctly.
     *
     * @since [*next-version*]
     */
    public function testConstructorArguments()
    {
        $message = uniqid('message-');
        $code = intval(rand(1, 99));
        $previous = $this->createException(uniqid('message-'), intval(rand(100, 199)), null);
        $container = $this->createContainer();
        $subject = $this->createInstance($message, $code, $previous, $container);

        $this->assertSame($message, $subject->getMessage(), 'The new test subject does not have the correct message');
        $this->assertSame($code, $subject->getCode(), 'The new test subject does not have the correct code');
        $this->assertSame($previous, $subject->getPrevious(), 'The new test subject does not have the correct inner exception');
        $this->assertSame($container, $subject->getContainer(), 'The new test subject does not have the correct container');
    }
}
