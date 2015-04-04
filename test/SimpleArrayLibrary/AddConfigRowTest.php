<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class AddConfigRowTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return void
     */
    public function test_function()
    {
        // invoke logic & test
        $this->assertEquals(
            array('foo' => array(
                'baz' => 1,
                'bar' => 2
            )),
            SimpleArrayLibrary::addConfigRow(
                array('foo' => array('baz' => 1)),
                array('foo', 'bar'),
                2
            )
        );
    }
}