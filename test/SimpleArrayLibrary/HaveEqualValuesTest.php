<?php

use \SimpleArrayLibrary\SimpleArrayLibrary;

/**
 * Tests haveEqualValues method with valid data
 */
class HaveEqualValuesTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param array $data
     *
     * @return void
     * @dataProvider getData
     */
    public function test_function(array $data)
    {
        // invoke logic
        $result = SimpleArrayLibrary::haveEqualValues($data['array1'], $data['array2']);

        // test
        $this->assertEquals($data['expected'], $result);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            // #0 equal values & keys
            [
                [
                    'array1'   => ['a' => 1],
                    'array2'   => ['a' => 1],
                    'expected' => true
                ]
            ],
            // #1 both empty arrays
            [
                [
                    'array1'   => [],
                    'array2'   => [],
                    'expected' => true
                ]
            ],
            // #2 equal values, not equal keys
            [
                [
                    'array1'   => ['a' => 1],
                    'array2'   => [1],
                    'expected' => true
                ]
            ],
            // #3 equal keys, but not values
            [
                [
                    'array1'   => [1],
                    'array2'   => [2],
                    'expected' => false
                ]
            ]
        ];
    }
}