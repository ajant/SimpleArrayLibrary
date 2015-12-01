<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class CountMinDepthXTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return void
     * @dataProvider getData
     */
    public function test_function(array $data)
    {
        // prepare
        $this->setExpectedException('InvalidArgumentException', 'Depth parameter must be non-negative integer');

        // invoke logic & test
        SimpleArrayLibrary::countMinDepth('a', $data['depth']);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 non int
            array (
                array(
                    'depth' => 'foo'
                )
            ),
            // #1 negative int
            array (
                array(
                    'depth' => -1
                )
            )
        );
    }
}