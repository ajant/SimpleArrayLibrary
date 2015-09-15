<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class HasOnlyKeysTest extends PHPUnit_Framework_TestCase
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
        $result = SimpleArrayLibrary::hasOnlyKeys($data['array'], $data['keys']);

        // test
        $this->assertEquals($data['expected'], $result);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 has all keys
            array(
                array(
                    'array'    => array('a' => 1, 'b' => 2),
                    'keys'     => array('a', 'b'),
                    'expected' => true
                )
            ),
            // #1 empty arrays are equal
            array(
                array(
                    'array'    => array(),
                    'keys'     => array(),
                    'expected' => true
                )
            ),
            // #2 doesn't have all keys when both arrays are not empty
            array(
                array(
                    'array'    => array('a' => 1, 'b' => 2),
                    'keys'     => array('a'),
                    'expected' => false
                )
            ),

            // #3 have more than expected keys
            array(
                array(
                    'array'    => array('a' => 1, 'b' => 2),
                    'keys'     => array('a', 'b', 'c'),
                    'expected' => false
                )
            ),
            // #4 key does not exists in array at all
            array(
                array(
                    'array'    => array('a' => 1, 'b' => 2),
                    'keys'     => array('c'),
                    'expected' => false
                )
            ),
            // #5 no key provided
            array(
                array(
                    'array'    => array('a' => 1),
                    'keys'     => array(),
                    'expected' => false
                )
            ),
            // #6 key provided array empty
            array(
                array(
                    'array'    => array(),
                    'keys'     => array('a'),
                    'expected' => false
                )
            ),
        );
    }
}