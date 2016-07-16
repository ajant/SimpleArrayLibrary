<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class SortArrayKeysByArrayTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param array $arrayToSort
     * @param array $orderArray
     * @param $expectedResults
     *
     * @dataProvider getData
     */
    public function test_function(array $arrayToSort, array $orderArray, $expectedResults)
    {
        // act
        $actualResults = SimpleArrayLibrary::sortArrayKeysByArray($arrayToSort, $orderArray);

        // assert
        $this->assertEquals($expectedResults, $actualResults);
    }

    public function getData()
    {
        return [
            // #0 Array to sort is smaller that order array
            [
                'arrayToSort' => [
                    'key3' => 'value3',
                    'key2' => 'value2',
                    'key1' => 'value1'
                ],
                'orderArray' => [
                    'key10',
                    'key1',
                    'key2',
                    'key3',
                    'key4'
                ],
                'expectedResults' => [
                    'key1' => 'value1',
                    'key2' => 'value2',
                    'key3' => 'value3'
                ]
            ],
            // #1 Array to sort is larger that order array
            [
                'arrayToSort' => [
                    'key6' => 'value6',
                    'key5' => 'value5',
                    'key4' => 'value4',
                    'key3' => 'value3',
                    'key2' => 'value2',
                    'key1' => 'value1'
                ],
                'orderArray' => [
                    'key2',
                    'key4',
                    'key5'
                ],
                'expectedResults' => [
                    'key2' => 'value2',
                    'key4' => 'value4',
                    'key5' => 'value5',
                    'key6' => 'value6',
                    'key3' => 'value3',
                    'key1' => 'value1'
                ]
            ],
            // #2 Both arrays have same size, and keys from arrayToSort are the same as values from orderArray
            [
                'arrayToSort' => [
                    'key1' => 'value1',
                    'key2' => 'value2',
                    'key3' => 'value3'
                ],
                'orderArray' => [
                    'key1',
                    'key2',
                    'key3'
                ],
                'expectedResults' => [
                    'key1' => 'value1',
                    'key2' => 'value2',
                    'key3' => 'value3'
                ]
            ],
            // #3 Both arrays have same size and every key matches with every value form orderArray
            [
                'arrayToSort' => [
                    'key1' => 'value1',
                    'key2' => 'value2',
                    'key3' => 'value3'
                ],
                'orderArray' => [
                    'key2',
                    'key3',
                    'key1'
                ],
                'expectedResults' => [
                    'key2' => 'value2',
                    'key3' => 'value3',
                    'key1' => 'value1'
                ]
            ],
            // #4 Both arrays have same size, but only some (in this case one) keys
            // match with values from orderArray
            [
                'arrayToSort' => [
                    'key1' => 'value1',
                    'key2' => 'value2',
                    'key3' => 'value3'
                ],
                'orderArray' => [
                    'key5',
                    'key3',
                    'key6'
                ],
                'expectedResults' => [
                    'key3' => 'value3',
                    'key1' => 'value1',
                    'key2' => 'value2'
                ]
            ],
            // #5 Array to sort does not have any key that match value from order array
            [
                'arrayToSort' => [
                    'key1' => 'value1',
                    'key2' => 'value2',
                    'key3' => 'value3'
                ],
                'orderArray' => [
                    'who knows what'
                ],
                'expectedResults' => [
                    'key1' => 'value1',
                    'key2' => 'value2',
                    'key3' => 'value3'
                ]
            ],
            // #6 Array to sort is multidimensional
            [
                'arrayToSort' => [
                    'key1' => [
                        'innerKey1' => []
                    ],
                    'key2' => [],
                ],
                'orderArray' => [
                    'key2'
                ],
                'expectedResults' => [
                    'key2' => [],
                    'key1' => [
                        'innerKey1' => []
                    ],
                ]
            ],
            // #7 Order array is empty
            [
                'arrayToSort' => [
                    'key1' => 'value1',
                    'key2' => 'value2'
                ],
                'orderArray' => [],
                'expectedResults' => [
                    'key1' => 'value1',
                    'key2' => 'value2'
                ]
            ],
            // #8 Order array is associative, but has proper ordering value
            [
                'arrayToSort' => [
                    'key1' => 'value1',
                    'key2' => 'value2'
                ],
                'orderArray' => ['key' => 'key2'],
                'expectedResults' => [
                    'key2' => 'value2',
                    'key1' => 'value1'
                ]
            ]
        ];
    }
}
