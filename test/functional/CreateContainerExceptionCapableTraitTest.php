<?php

namespace Dhii\Data\Container\FuncTest;

use Dhii\Data\Container\ContainerInterface;
use Xpmock\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Exception as RootException;
use Dhii\Data\Container\Exception\ContainerException;

class CreateContainerExceptionCapableTraitTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Data\Container\CreateContainerExceptionCapableTrait';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @param array $methods A list of methods to mock.
     *
     * @return MockObject
     */
    public function createInstance($methods = [])
    {
        $methods = $this->mergeValues($methods, [
        ]);

        $builder = $this->getMockBuilder(static::TEST_SUBJECT_CLASSNAME)
            ->setMethods($methods);

        $mock = $builder->getMockForTrait();

        return $mock;
    }

    /**
     * Merges the values of two arrays.
     *
     * The resulting product will be a numeric array where the values of both inputs are present, without duplicates.
     *
     * @since [*next-version*]
     *
     * @param array $destination The base array.
     * @param array $source      The array with more keys.
     *
     * @return array The array which contains unique values
     */
    public function mergeValues($destination, $source)
    {
        return array_keys(array_merge(array_flip($destination), array_flip($source)));
    }

    /**
     * Creates a new exception.
     *
     * @since [*next-version*]
     *
     * @param string $message The error message, if any.
     *
     * @return RootException The new exception.
     */
    public function createException($message = '')
    {
        return new RootException($message);
    }

    /**
     * Creates a new container.
     *
     * @since [*next-version*]
     *
     * @param array $map The entries for the container.
     *
     * @return ContainerInterface The new container.
     */
    public function createContainer(array $map = [])
    {
        return $this->mock('Dhii\Data\Container\ContainerInterface')
            ->get(function ($key) use ($map) {
                return isset($map[$key])
                    ? $map[$key]
                    : null;
            })
            ->has(function ($key) use ($map) {
                return isset($map[$key]);
            })
            ->new();
    }

    /**
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance();

        $this->assertInternalType(
            'object', $subject, 'A valid instance of the test subject could not be created.'
        );
    }

    /**
     * Tests that the `_createContainerException()` method works as expected.
     *
     * @since [*next-version*]
     */
    public function testCreateContainerException()
    {
        $subject = $this->createInstance();
        $_subject = $this->reflect($subject);
        $message = uniqid('message');
        $inner = $this->createException(uniqid('inner-message'));
        $container = $this->createContainer();

        $result = $_subject->_createContainerException($message, $inner, $container);
        try {
            throw $result;
        } catch (ContainerException $e) {
            $this->assertEquals($message, $e->getMessage(), 'Wrong message retrieved');
            $this->assertSame($inner, $e->getPrevious(), 'Wrong inner exception retrieved');
            $this->assertSame($container, $e->getContainer(), 'Wrong container retrieved');
        }
    }
}
