<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class IsSubArrayXTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return void
     */
    public function test_function()
    {
        // prepare
        $this->setExpectedException('InvalidArgumentException', 'Strict comparison parameter must be a boolean');

        // invoke logic & test
        SimpleArrayLibrary::isSubArray(array(), array(), array());
    }
}