<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class InsertSubArrayXTest extends PHPUnit_Framework_TestCase
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
        SimpleArrayLibrary::insertSubArray($data['array'], $data['subArray'], $data['overwrite'], $data['ignoreIfExists']);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 invalid overwrite parameter
            array(
                array(
                    'array'          => array('column' => 1),
                    'subArray'       => array('column' => 2),
                    'overwrite'      => array(),
                    'ignoreIfExists' => true,
                    'exception'      => 'InvalidArgumentException',
                    'errorMessage'   => 'Overwrite indicator must be a boolean'
                )
            ),
            // #1 invalid ignoreIfExists parameter
            array(
                array(
                    'array'          => array('column' => 1),
                    'subArray'       => array('column' => 2),
                    'overwrite'      => false,
                    'ignoreIfExists' => array(),
                    'exception'      => 'InvalidArgumentException',
                    'errorMessage'   => 'Ignore if exists indicator must be a boolean'
                )
            ),
            // #2 sub-array already exists and should not be overwritten and should not be ignored
            array(
                array(
                    'array'          => 1,
                    'subArray'       => 2,
                    'overwrite'      => false,
                    'ignoreIfExists' => false,
                    'exception'      => 'UnexpectedValueException',
                    'errorMessage'   => 'Sub-array already exists'
                )
            )
        );
    }
}