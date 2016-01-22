<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class IsAssociativeTest extends PHPUnit_Framework_TestCase
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
        $this->assertEquals($data['expResult'], SimpleArrayLibrary::isNumeric($data['array']));
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 numeric
            array(
                array(
                    'array'     => array(1, 1),
                    'expResult' => true
                )
            ),
            // #1 associative
            array(
                array(
                    'array'     => array('a' => 1, 'b' => array(1)),
                    'expResult' => false
                )
            ),
            // #2 mixed === associative
            array(
                array(
                    'array'     => array('a' => 1, array(1)),
                    'expResult' => false
                )
            ),
            // #3 empty no numeric keys, not numeric
            array(
                array(
                    'array'     => array(),
                    'expResult' => false
                )
            )
        );
    }
}