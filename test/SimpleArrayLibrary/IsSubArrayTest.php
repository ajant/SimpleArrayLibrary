<?php

use \SimpleArrayLibrary\SimpleArrayLibrary;

/**
 * Tests isSubArray method with valid data
 */
class IsSubArrayTest extends PHPUnit_Framework_TestCase
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
        $this->assertEquals($data['expResult'], SimpleArrayLibrary::isSubArray($data['array'], $data['subArray']));
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 sub array exists
            array(
                array(
                    'array'     => array(2, 1),
                    'subArray'  => array(2),
                    'expResult' => true
                )
            ),
            // #1 not a sub array, different key
            array(
                array(
                    'array'     => array('a' => 1, 'b' => array(1)),
                    'subArray'  => array('c' => 1),
                    'expResult' => false
                )
            ),
            // #2 not a sub array, different value
            array(
                array(
                    'array'     => array('a' => 1, 'b' => array(1)),
                    'subArray'  => array('a' => 2),
                    'expResult' => false
                )
            )
        );
    }
}