<?php

use \SimpleArrayLibrary\SimpleArrayLibrary;

class CountMaxDepthTest extends PHPUnit_Framework_TestCase
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
        $this->assertEquals($data['expResult'], SimpleArrayLibrary::countMaxDepth($data['array'], $data['depth']));
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
                    'depth'     => 1,
                    'expResult' => 2
                )
            ),
            // #1 non-rectangular
            array(
                array(
                    'array'     => array(1, 2, array(1)),
                    'depth'     => 0,
                    'expResult' => 2
                )
            ),
            // #2 non-array
            array(
                array(
                    'array'     => 1,
                    'depth'     => 1,
                    'expResult' => 1
                )
            )
        );
    }
}