<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class SortArrayByArrayXTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param array $arrayToSort
     * @param $orderArray
     * @return void
     *
     * @dataProvider getData
     */
    public function test_function(array $arrayToSort, $orderArray)
    {
        // prepare
        self::setExpectedException(UnexpectedValueException::class,
            'Both array to sort and order array must be of one dimensional arrays');

        // invoke logic & test
        SimpleArrayLibrary::sortArrayByArray($arrayToSort, $orderArray);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            // #0 Array to sort is not one dimensional
            [
                'arrayToSort' => [
                    'notOneDimKey' => ['test value']
                ],
                'orderArray' => ['test value']
            ],
            // #1 Order array is not one dimensional
            [
                'arrayToSort' => ['test value'],
                'orderArray' => [
                    'notOneDimKey' => ['test value']
                ]
            ],
            // #2 Both arrays are not one dimensional
            [
                'arrayToSort' => [
                    'notOneDimKey' => ['test value']
                ],
                'orderArray' => [
                    'notOneDimKey' => ['test value']
                ]
            ]
        ];
    }
}