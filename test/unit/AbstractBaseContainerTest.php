<?php

namespace Dhii\Data\Container\UnitTest;

use Dhii\Data\Container\AbstractBaseContainer as TestSubject;
use Dhii\Data\Container\Exception\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use Xpmock\TestCase;
use Exception as RootException;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_MockObject_MockBuilder as MockBuilder;

/**
 * Tests {@see TestSubject}.
 *
 * @since [*next-version*]
 */
class AbstractBaseContainerTest extends TestCase
{
    /**
     * The class name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\Data\Container\AbstractBaseContainer';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @param array $methods The methods to mock.
     *
     * @return MockObject|TestSubject The new instance.
     */
    public function createInstance($methods = [])
    {
        is_array($methods) && $methods = $this->mergeValues($methods, [
            '__',
        ]);

        $mock = $this->getMockBuilder(static::TEST_SUBJECT_CLASSNAME)
            ->setMethods($methods)
            ->getMockForAbstractClass();

        $mock->method('__')
                ->will($this->returnArgument(0));

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
     * Creates a mock that both extends a class and implements interfaces.
     *
     * This is particularly useful for cases where the mock is based on an
     * internal class, such as in the case with exceptions. Helps to avoid
     * writing hard-coded stubs.
     *
     * @since [*next-version*]
     *
     * @param string $className      Name of the class for the mock to extend.
     * @param string $interfaceNames Names of the interfaces for the mock to implement.
     *
     * @return MockBuilder The builder for a mock of an object that extends and implements
     *                     the specified class and interfaces.
     */
    public function mockClassAndInterfaces($className, $interfaceNames = [])
    {
        $paddingClassName = uniqid($className);
        $definition = vsprintf('abstract class %1$s extends %2$s implements %3$s {}', [
            $paddingClassName,
            $className,
            implode(', ', $interfaceNames),
        ]);
        eval($definition);

        return $this->getMockBuilder($paddingClassName);
    }

    /**
     * Creates a new exception.
     *
     * @since [*next-version*]
     *
     * @param string $message The exception message.
     *
     * @return RootException The new exception.
     */
    public function createException($message = '')
    {
        $mock = $this->getMockBuilder('Exception')
            ->setConstructorArgs([$message])
            ->getMock();

        return $mock;
    }

    /**
     * Creates a new Container exception.
     *
     * @since [*next-version*]
     *
     * @param string $message The exception message.
     *
     * @return MockObject|RootException|ContainerExceptionInterface The new exception.
     */
    public function createContainerException($message = '')
    {
        $mock = $this->mockClassAndInterfaces('Exception', ['Psr\Container\ContainerExceptionInterface'])
            ->setConstructorArgs([$message])
            ->getMock();

        return $mock;
    }

    /**
     * Creates a new Not Found exception.
     *
     * @since [*next-version*]
     *
     * @param string $message The exception message.
     *
     * @return MockObject|RootException|NotFoundExceptionInterface The new exception.
     */
    public function createNotFoundException($message = '')
    {
        $mock = $this->mockClassAndInterfaces('Exception', ['Psr\Container\NotFoundExceptionInterface'])
            ->setConstructorArgs([$message])
            ->getMock();

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

        $this->assertInternalType(
            'object',
            $subject,
            'A valid instance of the test subject could not be created.'
        );
    }

    /**
     * Tests that `get()` works as expected.
     *
     * @since [*next-version*]
     */
    public function test_Get()
    {
        $key = uniqid('key');
        $val = uniqid('val');
        $subject = $this->createInstance(['_getData']);
        $_subject = $this->reflect($subject);

        $subject->expects($this->exactly(1))
            ->method('_getData')
            ->with($key)
            ->will($this->returnValue($val));

        $result = $_subject->_get($key);
        $this->assertEquals($val, $result, 'Wrong data retrieved');
    }

    /**
     * Tests that `_get()` fails as expected if the key is not found.
     *
     * @since [*next-version*]
     */
    public function test_GetFailureNotFound()
    {
        $key = uniqid('key');
        $innerException = $this->createNotFoundException('Key not found');
        $exception = $this->createNotFoundException('Key not found');
        $subject = $this->createInstance(['_getData', '_createNotFoundException']);
        $_subject = $this->reflect($subject);

        $subject->expects($this->exactly(1))
            ->method('_getData')
            ->with($key)
            ->will($this->throwException($innerException));
        $subject->expects($this->exactly(1))
            ->method('_createNotFoundException')
            ->with(
                $this->isType('string'),
                null,
                $innerException,
                $subject,
                $key
            )
            ->will($this->returnValue($exception));

        $this->setExpectedException('Psr\Container\NotFoundExceptionInterface');
        $_subject->_get($key);
    }

    /**
     * Tests that `_get()` fails as expected if problem retrieving value.
     *
     * @since [*next-version*]
     */
    public function test_GetFailureException()
    {
        $key = uniqid('key');
        $innerException = $this->createException('Something went wrong');
        $exception = $this->createContainerException('Could not check for value');
        $subject = $this->createInstance(['_getData', '_createContainerException']);
        $_subject = $this->reflect($subject);

        $subject->expects($this->exactly(1))
            ->method('_getData')
            ->with($key)
            ->will($this->throwException($innerException));
        $subject->expects($this->exactly(1))
            ->method('_createContainerException')
            ->with(
                $this->isType('string'),
                null,
                $innerException,
                $subject
            )
            ->will($this->returnValue($exception));

        $this->setExpectedException('Psr\Container\ContainerExceptionInterface');
        $_subject->_get($key);
    }

    /**
     * Tests that `_has()` works as expected when determined to be true.
     *
     * @since [*next-version*]
     */
    public function test_Has()
    {
        $keyTrue = uniqid('key');
        $keyFalse = uniqid('key');
        $subject = $this->createInstance(['_hasData']);
        $_subject = $this->reflect($subject);

        $subject->expects($this->exactly(2))
            ->method('_hasData')
            ->will($this->returnValueMap([
                [$keyTrue, true],
                [$keyFalse, false],
            ]));

        $result = $_subject->_has($keyTrue);
        $this->assertTrue($result, 'Wrong data check result');

        $result = $_subject->_has($keyFalse);
        $this->assertFalse($result, 'Wrong data check result');
    }

    /**
     * Tests that `_has()` fails as expected if problem retrieving value.
     *
     * @since [*next-version*]
     */
    public function test_HasFailureException()
    {
        $key = uniqid('key');
        $innerException = $this->createException('Something went wrong');
        $exception = $this->createContainerException('Could not check for value');
        $subject = $this->createInstance(['_hasData', '_createContainerException']);
        $_subject = $this->reflect($subject);

        $subject->expects($this->exactly(1))
            ->method('_hasData')
            ->with($key)
            ->will($this->throwException($innerException));
        $subject->expects($this->exactly(1))
            ->method('_createContainerException')
            ->with(
                $this->isType('string'),
                null,
                $innerException,
                $subject
            )
            ->will($this->returnValue($exception));

        $this->setExpectedException('Psr\Container\ContainerExceptionInterface');
        $_subject->_has($key);
    }

    /**
     * Tests that `get()` works as expected.
     *
     * @since [*next-version*]
     */
    public function testGet()
    {
        $key = uniqid('key');
        $val = uniqid('val');
        $subject = $this->createInstance(['_get']);
        $_subject = $this->reflect($subject);

        $subject->expects($this->exactly(1))
            ->method('_get')
            ->with($key)
            ->will($this->returnValue($val));

        $result = $subject->get($key);
        $this->assertEquals($val, $result, 'Wrong value returned');
    }

    /**
     * Tests that `has()` works as expected.
     *
     * @since [*next-version*]
     */
    public function testHas()
    {
        $key = uniqid('key');
        $isHas = true;
        $subject = $this->createInstance(['_has']);
        $_subject = $this->reflect($subject);

        $subject->expects($this->exactly(1))
            ->method('_has')
            ->with($key)
            ->will($this->returnValue($isHas));

        $result = $subject->has($key);
        $this->assertEquals($isHas, $result, 'Wrong check result');
    }

    /**
     * Tests that `_construct()` works as expected.
     *
     * @since [*next-version*]
     */
    public function testConstruct()
    {
        $subject = $this->createInstance();
        $_subject = $this->reflect($subject);

        $_subject->_construct();
    }
}
