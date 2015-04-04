<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class AddConfigRowXTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return void
     */
    public function test_function()
    {
        // prepare
        $this->setExpectedException('UnexpectedValueException', 'Array of config keys must be numeric');

        // invoke logic & test
        SimpleArrayLibrary::addConfigRow([], ['z' => 1], 1);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 invalid keys array
            array(
                array(
                    'config'       => array(),
                    'keys'         => array('foo' => 1),
                    'value'        => 1,
                    'exception'    => 'UnexpectedValueException',
                    'errorMessage' => 'Array of config keys must be numeric'
                )
            ),
            // #1 row already exists in the config
            array(
                array(
                    'config'       => array('foo' => 1),
                    'keys'         => array('foo' => 2),
                    'value'        => false,
                    'exception'    => 'UnexpectedValueException',
                    'errorMessage' => 'Sub-array already exists'
                )
            )
        );
    }
}