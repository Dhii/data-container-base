<?php

namespace Dhii\Data\Container\UnitTest;

use Xpmock\TestCase;

/**
 * Tests {@see \Dhii\Data\Container\AbstractContainerBase}.
 *
 * @since [*next-version*]
 */
class AbstractContainerBaseTest extends TestCase
{
    /**
     * The name of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'Dhii\\Data\\Container\\AbstractContainerBase';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return \Dhii\Data\Container\AbstractContainerBase
     */
    public function createInstance()
    {
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
                ->has()
                ->get()
                ->new();

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

        $this->assertInstanceOf(
            self::TEST_SUBJECT_CLASSNAME, $subject, 'A valid instance of the test subject could not be created'
        );
    }

    /**
     * Tests that a container exception can be created correctly.
     *
     * @since [*next-version*]
     */
    public function testCreateContainerException()
    {
        $subject = $this->createInstance();
        $_subject = $this->reflect($subject);

        $result = $_subject->_createContainerException();
        $this->assertInstanceOf('Dhii\\Data\\Container\\Exception\\ContainerExceptionInterface', $result, 'A valid container exception could not be created');
    }

    /**
     * Tests that a not found exception can be created correctly.
     *
     * @since [*next-version*]
     */
    public function testCreateNotFoundException()
    {
        $subject = $this->createInstance();
        $_subject = $this->reflect($subject);

        $result = $_subject->_createNotFoundException();
        $this->assertInstanceOf('Dhii\\Data\\Container\\Exception\\NotFoundExceptionInterface', $result, 'A valid not found exception could not be created');
    }
}
