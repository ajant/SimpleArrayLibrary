<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class DeleteColumnsTest extends PHPUnit_Framework_TestCase
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
        $this->assertEquals($data['expResult'], SimpleArrayLibrary::deleteColumns($data['matrix'], $data['columns']));
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 delete one column, not present in all rows
            array(
                array(
                    'matrix'    => array(array('foo' => 2, 'bar' => 1), array('bar' => 1)),
                    'columns'   => array('foo'),
                    'expResult' => array(array('bar' => 1), array('bar' => 1))
                )
            ),
            // #1 delete all columns, wherever they ara present
            array(
                array(
                    'matrix'    => array(array('foo' => 2, 'bar' => 1), array('bar' => 1), array()),
                    'columns'   => array('foo', 'bar'),
                    'expResult' => array(array(), array(), array())
                )
            )
        );
    }
}