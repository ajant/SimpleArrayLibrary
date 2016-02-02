<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class SelectRandomArrayElementsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getData
     */
    public function testMethod($array, $expected)
    {
        // arrange
        $requestedNumberOfElements = 2;

        // act
        $result = SimpleArrayLibrary::selectRandomArrayElements($array, $requestedNumberOfElements);

        // assert
        if (count($expected) > $requestedNumberOfElements) {
            $this->assertCount(2, $result);
            foreach ($result as $element) {
                if (!in_array($element, $expected)) {
                    $this->fail('Element not among expected elements');
                }
            }
        } else {
            $this->assertEquals($expected, $result);
        }
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            // #0 empty array
            [
                'array' => [],
                'expected' => [],
            ],
            // #1 fewer elements requested then array contains
            [
                'array' => [1],
                'expected' => [1],
            ],
            // #2 same number of elements requested as array contains
            [
                'array' => [1, 2],
                'expected' => [1, 2],
            ],
            // #3 more elements requested then array contains
            [
                'array' => [1, 2, 3],
                'expected' => [1, 2, 3],
            ],
        ];
    }
}