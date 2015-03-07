<?php

use \SimpleArrayLibrary\SimpleArrayLibrary;

class GetColumnsXTest extends PHPUnit_Framework_TestCase
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
        SimpleArrayLibrary::getColumns($data['array'], $data['columns'], $data['allRowsMustHaveAllColumns']);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 array is not at least 2 dimensional
            array(
                array(
                    'array'                     => array(array(1), 'a' => 1),
                    'columns'                   => array(0),
                    'allRowsMustHaveAllColumns' => false,
                    'exception'                 => 'UnexpectedValueException',
                    'errorMessage'              => 'Array element "a" is not an array'
                )
            ),
            // #1 columns array contain invalid values
            array(
                array(
                    'array'                     => array(array(1), array('a' => 1)),
                    'columns'                   => array(0, array()),
                    'allRowsMustHaveAllColumns' => false,
                    'exception'                 => 'InvalidArgumentException',
                    'errorMessage'              => 'Invalid column type in columns array, index "1"'
                )
            ),
            // #2 column found, but sometimes it's an array itself
            array(
                array(
                    'array'                     => array('a' => array(1), array(1, 2)),
                    'columns'                   => array(0, 1),
                    'allRowsMustHaveAllColumns' => true,
                    'exception'                 => 'UnexpectedValueException',
                    'errorMessage'              => 'Row "a" is missing column: "1"'
                )
            ),
            // #3 invalid $allRowsMustHaveAllColumns
            array(
                array(
                    'array'                     => array('a' => array(1), array(1, 2)),
                    'columns'                   => array(0, 1),
                    'allRowsMustHaveAllColumns' => array(),
                    'exception'                 => 'InvalidArgumentException',
                    'errorMessage'              => 'allRowsMustHaveAllColumns flag must be boolean'
                )
            )
        );
    }
}