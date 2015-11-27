<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class CountMaxDepthXTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return void
     */
    public function test_function()
    {
        // prepare
        $this->setExpectedException(
            get_class(new PHPUnit_Framework_Error("", 0, "", 1))
        );

        // invoke logic & test
        SimpleArrayLibrary::countMaxDepth('a'); //This throws a Catchable fatal error

        $this->fail('Expected exception');
    }
}