<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class TransposeTest extends PHPUnit_Framework_TestCase
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
        $this->assertEquals($data['expResult'], SimpleArrayLibrary::transpose($data['matrix']));
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 column required & present
            array(
                array(
                    'matrix' => array(
                        array(1, 2, 3),
                        array(4, 5, 6)
                    ),
                    'expResult' => array(
                        array(1, 4),
                        array(2, 5),
                        array(3, 6)
                    )
                )
            )
        );
    }
}