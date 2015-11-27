<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class CountMaxDepthIterativeXTest extends PHPUnit_Framework_TestCase
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
        SimpleArrayLibrary::countMaxDepthIterative('a'); //This throws a Catchable fatal error

        $this->fail('Expected exception');
    }
}