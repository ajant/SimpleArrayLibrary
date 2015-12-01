<?php

class IsLogicallyCastableToIntTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getData
     */
    public function testFunction($input, $expected)
    {
        // prepare
        $reflection = new ReflectionClass('SimpleArrayLibrary\SimpleArrayLibrary');
        $method = $reflection->getMethod('isLogicallyCastableToInt');
        $method->setAccessible(true);

        // invoke logic
        $result = $method->invokeArgs(null, [$input]);

        // test
        $this->assertEquals($expected, $result);
    }

    public function getData()
    {
        return [
            // #0 non-int string
            [
                'input' => 'foo',
                'expected' => false
            ],
            // #1 int string
            [
                'input' => '1',
                'expected' => true
            ],
            // #2 float
            [
                'input' => 1.1,
                'expected' => false
            ],
            // #3 bool
            [
                'input' => true,
                'expected' => false
            ],
            // #4 array
            [
                'input' => [],
                'expected' => false
            ],
            // #5 object
            [
                'input' => new stdClass(),
                'expected' => false
            ]
        ];
    }
}