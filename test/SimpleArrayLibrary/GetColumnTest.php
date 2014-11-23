<?php

use \SimpleArrayLibrary\SimpleArrayLibrary;

/**
 * Tests getColumn method with valid data
 */
class GetColumnTest extends PHPUnit_Framework_TestCase
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
        $this->assertEquals($data['expResult'], SimpleArrayLibrary::getColumn($data['matrix'], $data['column']));
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 invalid matrix
            array(
                array(
                    'matrix'    => array(array('a' => 1), array(1)),
                    'column'    => 'a',
                    'expResult' => false
                )
            ),
            // #1
            array(
                array(
                    'matrix'    => array(array(1, 2), array(4)),
                    'column'    => 0,
                    'expResult' => array(1, 4)
                )
            ),
            // #2
            array(
                array(
                    'matrix'    => array(array(1, 2, 3, 4), array(array(1, 2, 3, 4)), array(array(1, 2, 3, 4))),
                    'column'    => 0,
                    'expResult' => array(1, array(1, 2, 3, 4), array(1, 2, 3, 4))
                )
            ),
            // #3
            array(
                array(
                    'matrix'    => array(array(1, 2, 3, 4), array(1, 2, 3, 4), array(1, 2, 3, 4)),
                    'column'    => 2,
                    'expResult' => array(3, 3, 3)
                )
            )
        );
    }
}