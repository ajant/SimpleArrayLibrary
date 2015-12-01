<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class CountMaxDepthIterativeTest extends PHPUnit_Framework_TestCase
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
        $this->assertEquals($data['expResult'], SimpleArrayLibrary::countMaxDepthIterative($data['array']));
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 rectangular
            array(
                array(
                    'array'     => array(),
                    'expResult' => 1
                )
            ),
            // #1 non-rectangular
            array(
                array(
                    'array'     => array(1, 2, array(1)),
                    'expResult' => 2
                )
            )
        );
    }
}