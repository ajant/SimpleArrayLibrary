<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class SelectRandomArrayElementsXTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param array $data
     *
     * @return void
     * @dataProvider getData
     */
    public function test_function(array $data)
    {
        // prepare
        $this->setExpectedException('InvalidArgumentException', 'Number of requested elements parameter must be a positive integer');

        // invoke logic & test
        SimpleArrayLibrary::selectRandomArrayElements(array(1), $data['numberOfRequiredElements']);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 negative integer
            array(
                array(
                    'numberOfRequiredElements' => -1
                )
            ),
            // #1 zero
            array(
                array(
                    'numberOfRequiredElements' => 0
                )
            ),
            // #2 not an integer
            array(
                array(
                    'numberOfRequiredElements' => 'foo'
                )
            )
        );
    }
}