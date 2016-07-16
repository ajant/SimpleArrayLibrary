<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class SortArrayKeysByArrayXTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param array $arrayToSort
     * @param $orderArray
     * @param $expectedException
     * @param $exceptionMessage
     * @dataProvider getData
     */
    public function test_function(array $arrayToSort, $orderArray, $expectedException, $exceptionMessage)
    {
        // prepare
        self::setExpectedException($expectedException, $exceptionMessage);

        // invoke logic & test
        SimpleArrayLibrary::sortArrayKeysByArray($arrayToSort, $orderArray);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            // #0 Array to sort is not associative
            [
                'arrayToSort' => ['test value'],
                'orderArray' => ['test value'],
                'expectedException' => UnexpectedValueException::class,
                'exceptionMessage' => 'Array to sort must be associative'
            ],
            // #1 Ordering array is multidimensional
            [
                'arrayToSort' => ['test key' => 'test value'],
                'orderArray' => [ // invalid
                    'testKey' => []
                ],
                'expectedException' => UnexpectedValueException::class,
                'exceptionMessage' => 'Ordering array must be one dimensional'
            ]
        ];
    }
}