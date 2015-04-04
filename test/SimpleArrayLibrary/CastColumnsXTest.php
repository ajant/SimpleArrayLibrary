<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class CastColumnsXTest extends PHPUnit_Framework_TestCase
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
        SimpleArrayLibrary::castColumns($data['matrix'], $data['map'], $data['allKeysMustBePresent']);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 invalid allKeysMustBePresent parameter
            array(
                array(
                    'matrix'               => array(),
                    'map'                  => array(),
                    'allKeysMustBePresent' => array(),
                    'exception'            => 'InvalidArgumentException',
                    'errorMessage'         => 'Third parameter must be a boolean'
                )
            ),
            // #1 input array one dimensional, no columns to speak of
            array(
                array(
                    'matrix'               => array('column' => 1),
                    'map'                  => array('column' => SimpleArrayLibrary::TYPE_FLOAT),
                    'allKeysMustBePresent' => false,
                    'exception'            => 'UnexpectedValueException',
                    'errorMessage'         => 'Can not cast columns on one dimensional array'
                )
            ),
            // #2 invalid cast type
            array(
                array(
                    'matrix'               => array(array('column' => 'value')),
                    'map'                  => array('column' => 'invalidCast'),
                    'allKeysMustBePresent' => false,
                    'exception'            => 'UnexpectedValueException',
                    'errorMessage'         => 'Invalid type'
                )
            ),
            // #3 all columns must be present, but a column is missing on some of the rows
            array(
                array(
                    'matrix'               => array(array('column' => 'value')),
                    'map'                  => array('missingColumn' => SimpleArrayLibrary::TYPE_FLOAT),
                    'allKeysMustBePresent' => true,
                    'exception'            => 'UnexpectedValueException',
                    'errorMessage'         => 'Column: missingColumn missing in row: 0'
                )
            )
        );
    }
}