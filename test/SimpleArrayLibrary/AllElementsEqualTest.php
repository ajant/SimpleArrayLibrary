<?php

use \SimpleArrayLibrary\SimpleArrayLibrary;

class AllElementsEqualTest extends PHPUnit_Framework_TestCase
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
        if (isset($data['value'])) {
            $this->assertEquals($data['expResult'], SimpleArrayLibrary::allElementsEqual($data['array'], $data['value']));
        } else {
            $this->assertEquals($data['expResult'], SimpleArrayLibrary::allElementsEqual($data['array']));
        }
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 value provided, all elements equal to it
            array(
                array(
                    'array'     => array(1, 1),
                    'value'     => 1,
                    'expResult' => true
                )
            ),
            // #1 value provided, not all elements equal to it
            array(
                array(
                    'array'     => array(1, array(1)),
                    'value'     => 1,
                    'expResult' => false
                )
            ),
            // #2 value not provided, all elements not equal
            array(
                array(
                    'array'     => array(array(1, 2, 3, 4), array(array(1, 2, 3, 4)), array(array(1, 2, 3, 4))),
                    'expResult' => false
                )
            ),
            // #3 value not provided, all elements equal
            array(
                array(
                    'array'     => array(array(array(1, 2, 3, 4)), array(array(1, 2, 3, 4)), array(array(1, 2, 3, 4))),
                    'expResult' => true
                )
            )
        );
    }
}