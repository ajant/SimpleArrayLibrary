<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class GetRectangularDimensionsTest extends PHPUnit_Framework_TestCase
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
        $this->assertEquals($data['expResult'], SimpleArrayLibrary::getRectangularDimensions($data['array']));
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 1 level, 1 element
            array(
                array(
                    'array'     => array(1),
                    'expResult' => array(1)
                )
            ),
            // #1 non rectangular
            array(
                array(
                    'array'     => array(1, array(1)),
                    'expResult' => -1
                )
            ),
            // #2 3 levels: 4 elements on the deepest level, 1 element on middle level, 3 on the shallowest
            array(
                array(
                    'array'     => array(array(array(1, 2, 3, 4)), array(array(1, 2, 3, 4)), array(array(1, 2, 3, 4))),
                    'expResult' => array(4, 1, 3)
                )
            ),
            // #3 not rectangular on lower level
            array(
                array(
                    'array'     => array(array(1, 1, 1), array(1, 2, 2, 1)),
                    'expResult' => -1
                )
            ),
            // #4 one of sub arrays not rectangular
            array(
                array(
                    'array'     => array(array(array(1, 2), array(1)), array(array(1), array(1))),
                    'expResult' => -1
                )
            )
        );
    }
}