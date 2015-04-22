<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class DeleteColumnsXTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param array $data
     *
     * @return void
     * @dataProvider getData
     */
    public function test_function(array $data)
    {
        // prepare
        $this->setExpectedException($data['exception'], $data['errorMessage']);

        // invoke logic & test
        SimpleArrayLibrary::deleteColumns($data['matrix'], $data['columns']);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 not a matrix
            array(
                array(
                    'matrix'       => array(),
                    'columns'      => 'foo',
                    'exception'    => 'UnexpectedValueException',
                    'errorMessage' => 'Can not delete columns on one dimensional array'
                )
            ),
            // #1 invalid columns list
            array(
                array(
                    'matrix'       => array(array()),
                    'columns'      => array(array()),
                    'exception'    => 'InvalidArgumentException',
                    'errorMessage' => 'Invalid column'
                )
            ),
            // #2 invalid columns list
            array(
                array(
                    'matrix'       => array(array()),
                    'column'       => 'foo',
                    'exception'    => 'InvalidArgumentException',
                    'errorMessage' => 'Invalid column'
                )
            )
        );
    }
}