<?php

use \SimpleArrayLibrary\SimpleArrayLibrary;

/**
 * Tests countMaxDepth method with invalid data
 */
class CountMaxDepthXTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return void
     */
    public function test_function()
    {
        // prepare
        $this->setExpectedException('InvalidArgumentException', 'Depth parameter must be an integer');

        // invoke logic & test
        SimpleArrayLibrary::countMaxDepth('a', 'z');
    }
}