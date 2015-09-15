<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class HaveSameValuesTest extends PHPUnit_Framework_TestCase
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
        $result = SimpleArrayLibrary::haveSameValues($data['array1'], $data['array2']);

        // test
        $this->assertEquals($data['expected'], $result);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 same values & keys
            array(
                array(
                    'array1'   => array('a' => 1),
                    'array2'   => array('a' => 1),
                    'expected' => true
                )
            ),
            // #1 both empty arrays
            array(
                array(
                    'array1'   => array(),
                    'array2'   => array(),
                    'expected' => true
                )
            ),
            // #2 same values, not same keys
            array(
                array(
                    'array1'   => array('a' => 1),
                    'array2'   => array(1),
                    'expected' => true
                )
            ),
            // #3 same keys, but not values
            array(
                array(
                    'array1'   => array(1),
                    'array2'   => array(2),
                    'expected' => false
                )
            )
        );
    }
}