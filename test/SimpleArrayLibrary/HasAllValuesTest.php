<?php

use \SimpleArrayLibrary\SimpleArrayLibrary;

/**
 * Tests hasAllKeys method with valid data
 */
class HasAllValuesTest extends PHPUnit_Framework_TestCase
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
        $result = SimpleArrayLibrary::hasAllValues($data['array'], $data['values']);

        // test
        $this->assertEquals($data['expected'], $result);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 non empty array and keys
            array(
                array(
                    'array'    => array('a' => 1),
                    'values'   => array(1),
                    'expected' => true
                )
            ),
            // #1 both empty array and keys
            array(
                array(
                    'array'    => array(),
                    'values'   => array(),
                    'expected' => true
                )
            ),
            // #2 non empty array and empty keys
            array(
                array(
                    'array'    => array('a' => 1),
                    'values'   => array(),
                    'expected' => true
                )
            ),
            // #3 value is missing
            array(
                array(
                    'array'    => array('b' => 1),
                    'values'   => array('b' => 2),
                    'expected' => false
                )
            ),
            // #4 value is missing
            array(
                array(
                    'array'    => array('b', 1),
                    'values'   => array('a', 'b'),
                    'expected' => false
                )
            ),
            // #5 empty array, non empty values
            array(
                array(
                    'array'    => array(),
                    'values'   => array('a'),
                    'expected' => false
                )
            )
        );
    }
}