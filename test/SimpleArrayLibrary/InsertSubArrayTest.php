<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class InsertSubArrayTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param array $data
     *
     * @return void
     * @dataProvider getData
     */
    public function test_function(array $data)
    {
        // invoke logic & test
        $this->assertEquals($data['expResult'], SimpleArrayLibrary::insertSubArray($data['array'], $data['subArray'], $data['overwrite'], $data['ignoreIfExists']));
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 not both inputs are arrays, array overwritten by sub-array
            array(
                array(
                    'array'          => array(1),
                    'subArray'       => 1,
                    'overwrite'      => true,
                    'ignoreIfExists' => true,
                    'expResult'      => 1
                )
            ),
            // #1 not both inputs are arrays, array overwritten by sub-array
            array(
                array(
                    'array'          => 1,
                    'subArray'       => 2,
                    'overwrite'      => true,
                    'ignoreIfExists' => true,
                    'expResult'      => 2
                )
            ),
            // #2 not both inputs are arrays, array overwritten by sub-array
            array(
                array(
                    'array'          => 1,
                    'subArray'       => array(1),
                    'overwrite'      => true,
                    'ignoreIfExists' => true,
                    'expResult'      => array(1)
                )
            ),
            // #3 sub-array already exists and should not be overwritten
            array(
                array(
                    'array'          => array('foo' => 1),
                    'subArray'       => array('foo' => 2),
                    'overwrite'      => false,
                    'ignoreIfExists' => true,
                    'expResult'      => array('foo' => 1)
                )
            ),
            // #4 sub-array already exists and should be overwritten
            array(
                array(
                    'array'          => array('foo' => 1),
                    'subArray'       => array('foo' => 2),
                    'overwrite'      => true,
                    'ignoreIfExists' => true,
                    'expResult'      => array('foo' => 2)
                )
            ),
            // #5 sub-array inserted
            array(
                array(
                    'array'          => array('foo' => 1),
                    'subArray'       => array('bar' => 2),
                    'overwrite'      => true,
                    'ignoreIfExists' => true,
                    'expResult'      => array('foo' => 1, 'bar' => 2)
                )
            )
        );
    }
}