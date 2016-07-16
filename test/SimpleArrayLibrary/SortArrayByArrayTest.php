<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class SortArrayByArrayTest extends PHPUnit_Framework_TestCase
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
        $actualResults = SimpleArrayLibrary::sortArrayByArray($arrayToSort, $orderArray);

        // assert
        $this->assertEquals($expectedResults, $actualResults);
    }

    public function getData()
    {
        return [
            // #0 Array to sort is smaller that order array
            [
                'arrayToSort' => [
                    'sort3',
                    'sort2',
                    'sort1'
                ],
                'orderArray' => [
                    'sort10',
                    'sort1',
                    'sort2',
                    'sort3',
                    'sort4'
                ],
                'expectedResults' => [
                    'sort1',
                    'sort2',
                    'sort3'
                ]
            ],
            // #1 Array to sort is larger that order array
            [
                'arrayToSort' => [
                    'sort6',
                    'sort5',
                    'sort4',
                    'sort3',
                    'sort2',
                    'sort1'
                ],
                'orderArray' => [
                    'sort2',
                    'sort4',
                    'sort5'
                ],
                'expectedResults' => [
                    'sort2',
                    'sort4',
                    'sort5',
                    'sort6',
                    'sort3',
                    'sort1'
                ]
            ],
            // #2 Both arrays have same size and elements in same order
            [
                'arrayToSort' => [
                    'sort1',
                    'sort2',
                    'sort3'
                ],
                'orderArray' => [
                    'sort1',
                    'sort2',
                    'sort3'
                ],
                'expectedResults' => [
                    'sort1',
                    'sort2',
                    'sort3'
                ]
            ],
            // #3 Both arrays have same size and elements in different order
            [
                'arrayToSort' => [
                    'sort1',
                    'sort2',
                    'sort3'
                ],
                'orderArray' => [
                    'sort2',
                    'sort3',
                    'sort1'
                ],
                'expectedResults' => [
                    'sort2',
                    'sort3',
                    'sort1'
                ]
            ],
            // #4 Both arrays have same size with some different elements
            [
                'arrayToSort' => [
                    'sort1',
                    'sort2',
                    'sort3'
                ],
                'orderArray' => [
                    'sort5',
                    'sort3',
                    'sort6'
                ],
                'expectedResults' => [
                    'sort3',
                    'sort1',
                    'sort2'
                ]
            ],
            // #5 Array to sort does not have any same elements as order array
            [
                'arrayToSort' => [
                    'sort1',
                    'sort2',
                    'sort3'
                ],
                'orderArray' => [
                    'who knows what'
                ],
                'expectedResults' => [
                    'sort1',
                    'sort2',
                    'sort3'
                ]
            ],
            // #6 Both arrays empty
            [
                'arrayToSort' => [],
                'orderArray' => [],
                'expectedResults' => []
            ],
            // #7 Array to sort is empty
            [
                'arrayToSort' => [],
                'orderArray' => ['some ordering value'],
                'expectedResults' => []
            ],
            // #8 Order array is empty
            [
                'arrayToSort' => [
                    'value1',
                    'value2'
                ],
                'orderArray' => [],
                'expectedResults' => [
                    'value1',
                    'value2'
                ]
            ]
        ];
    }
}
