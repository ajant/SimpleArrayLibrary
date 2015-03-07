<?php

use \SimpleArrayLibrary\SimpleArrayLibrary;

/**
 * Tests getColumn method with valid data
 */
class GetColumnsTest extends PHPUnit_Framework_TestCase
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
        if (!empty($data['allRowsMustHaveAllColumns'])) {
            $this->assertEquals($data['expResult'], SimpleArrayLibrary::getColumns($data['matrix'], $data['columns'], $data['allRowsMustHaveAllColumns']));
        } else {
            $this->assertEquals($data['expResult'], SimpleArrayLibrary::getColumns($data['matrix'], $data['columns']));
        }
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 column doesn't exist in all rows
            array(
                array(
                    'matrix'    => array(array('a' => 1), array(1)),
                    'columns'   => array('a'),
                    'expResult' => array('a' => array(1))
                )
            ),
            // #1 column found in all rows
            array(
                array(
                    'matrix'    => array(array(1, 2), array(4)),
                    'columns'   => array(0),
                    'expResult' => array(array(1, 4))
                )
            ),
            // #2 column found, but sometimes it's an array itself
            array(
                array(
                    'matrix'    => array(array(1, 2, 3, 4), array(array(1, 2, 3, 4)), array(array(1, 2, 3, 4))),
                    'columns'   => array(0),
                    'expResult' => array(array(1, array(1, 2, 3, 4), array(1, 2, 3, 4)))
                )
            ),
            // #3 columns found
            array(
                array(
                    'matrix'    => array(array(1, 2, 3, 4), array(1, 2, 3, 4), array(1, 2, 3, 4)),
                    'columns'   => array(0 ,2),
                    'expResult' => array(0 => array(1, 1, 1), 2 => array(3, 3, 3))
                )
            ),
            // #4 column found, associative array
            array(
                array(
                    'matrix'    => array(
                        array('foo' => 1, 'bar' => 3, 'baz' => 3),
                        array('foo' => 2, 'bar' => 2, 'baz' => 3),
                        array('foo' => 3, 'bar' => 1, 'baz' => 3)
                    ),
                    'columns'   => array('foo', 'bar'),
                    'expResult' => array(
                        'foo' => array(1, 2, 3),
                        'bar' => array(3, 2, 1),
                    )
                )
            ),
            // #5 one column not present in all rows, associative array
            array(
                array(
                    'matrix'    => array(
                        'row1' => array('foo' => 1, 'bar' => 3, 'baz' => 3),
                        'row2' => array('foo' => 2, 'baz' => 3),
                        'row3' => array('foo' => 3, 'bar' => 1, 'baz' => 3)
                    ),
                    'columns'   => array('foo', 'bar'),
                    'expResult' => array(
                        'foo' => array('row1' => 1, 'row2' => 2, 'row3' => 3),
                        'bar' => array('row1' => 3, 'row3' => 1),
                    )
                )
            )
        );
    }
}