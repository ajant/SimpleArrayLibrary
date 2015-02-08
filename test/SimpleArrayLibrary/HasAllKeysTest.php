<?php

use \SimpleArrayLibrary\SimpleArrayLibrary;

/**
 * Tests hasAllKeys method with valid data
 */
class HasAllKeysTest extends PHPUnit_Framework_TestCase
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
        $result = SimpleArrayLibrary::hasAllKeys($data['array'], $data['keys']);

        // test
        $this->assertEquals($data['expected'], $result);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            // #0 non empty array and keys
            [
                [
                    'array'    => ['a' => 1],
                    'keys'     => ['a'],
                    'expected' => true
                ]
            ],
            // #1 both empty array and keys
            [
                [
                    'array'    => [],
                    'keys'     => [],
                    'expected' => true
                ]
            ],
            // #2 non empty array and empty keys
            [
                [
                    'array'    => ['a' => 1],
                    'keys'     => [],
                    'expected' => true
                ]
            ],
            // #3 key is missing
            [
                [
                    'array'    => ['b' => 1],
                    'keys'     => ['a'],
                    'expected' => false
                ]
            ],
            // #4 key is missing
            [
                [
                    'array'    => ['b' => 1],
                    'keys'     => ['a', 'b'],
                    'expected' => false
                ]
            ],
            // #5 empty array, non empty keys
            [
                [
                    'array'    => [],
                    'keys'     => ['a'],
                    'expected' => false
                ]
            ]
        ];
    }
}