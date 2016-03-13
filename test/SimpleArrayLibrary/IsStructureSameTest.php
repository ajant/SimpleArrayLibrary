<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class IsStructureSameTest extends PHPUnit_Framework_TestCase
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
        $this->assertEquals($data['expResult'], SimpleArrayLibrary::isStructureSame($data['array1'], $data['array2']));
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 neither is arrays
            array(
                array(
                    'array1' => 1,
                    'array2' => 'a',
                    'expResult' => true
                )
            ),
            // #1 empty arrays
            array(
                array(
                    'array1' => array(),
                    'array2' => array(),
                    'expResult' => true
                )
            ),
            // #2 equal arrays
            array(
                array(
                    'array1' => array(array(array()), array(), array(array(), array())),
                    'array2' => array(array(array()), array(), array(array(), array())),
                    'expResult' => true
                )
            ),
            // #3 equal depths, no non-array leafs
            array(
                array(
                    'array1' => array('a' => 1, 'b' => array(1)),
                    'array2' => array('a' => 2),
                    'expResult' => false
                )
            ),
            // #4 equal keys, different values
            array(
                array(
                    'array1' => array('a' => 1, 'b' => 'a'),
                    'array2' => array('a' => 2, 'b' => 1.1),
                    'expResult' => true
                )
            ),
            // #5 array & non-array
            array(
                array(
                    'array1' => array('a' => 1, 'b' => array(1)),
                    'array2' => 4,
                    'expResult' => false
                )
            ),
            // #6 arrays different depths
            array(
                array(
                    'array1' => array('a' => array(1)),
                    'array2' => array('a' => 2),
                    'expResult' => false
                )
            ),
            // #7 arrays non same keys, same values
            array(
                array(
                    'array1' => array('a' => 1, 'b' => array(1)),
                    'array2' => array('c' => 1, 'd' => array(1)),
                    'expResult' => false
                )
            ),
        );
    }
}