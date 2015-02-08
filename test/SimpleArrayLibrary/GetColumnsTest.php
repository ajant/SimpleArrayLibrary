<?php

use \SimpleArrayLibrary\SimpleArrayLibrary;

/**
 * Tests getColumn method with valid data
 */
class GetColumnsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param array $data
     *
     * @return void
     * @dataProvider getData
     */
    public function test_function(array $data)
    {
        // invoke logic & test
        $this->assertEquals($data['expResult'], SimpleArrayLibrary::getColumns($data['matrix'], $data['columns']));
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            // #0 column doesn't exist in all rows
            [
                [
                    'matrix'    => [['a' => 1], [1]],
                    'columns'   => ['a'],
                    'expResult' => false
                ]
            ],
            // #1 column found
            [
                [
                    'matrix'    => [[1, 2], [4]],
                    'columns'   => [0],
                    'expResult' => [[1, 4]]
                ]
            ],
            // #2 column found, but sometimes it's an array itself
            [
                [
                    'matrix'    => [[1, 2, 3, 4], [[1, 2, 3, 4]], [[1, 2, 3, 4]]],
                    'columns'   => [0],
                    'expResult' => [[1, [1, 2, 3, 4], [1, 2, 3, 4]]]
                ]
            ],
            // #3 column found
            [
                [
                    'matrix'    => [[1, 2, 3, 4], [1, 2, 3, 4], [1, 2, 3, 4]],
                    'columns'   => [2],
                    'expResult' => [2 => [3, 3, 3]]
                ]
            ],
            // #4 column found, associative array
            [
                [
                    'matrix'    => [
                        ['foo' => 1, 'bar' => 3, 'baz' => 3],
                        ['foo' => 2, 'bar' => 2, 'baz' => 3],
                        ['foo' => 3, 'bar' => 1, 'baz' => 3]
                    ],
                    'columns'   => ['foo', 'bar'],
                    'expResult' => [
                        'foo' => [1, 2, 3],
                        'bar' => [3, 2, 1],
                    ]
                ]
            ],
            // #5 one column not present in all rows
            [
                [
                    'matrix'    => [
                        ['foo' => 1, 'bar' => 3, 'baz' => 3],
                        ['foo' => 2, 'baz' => 3],
                        ['foo' => 3, 'bar' => 1, 'baz' => 3]
                    ],
                    'columns'   => ['foo', 'bar'],
                    'expResult' => false
                ]
            ]
        ];
    }
}