<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class SetColumnTest extends PHPUnit_Framework_TestCase
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
        $this->assertEquals($data['expResult'], SimpleArrayLibrary::setColumn($data['matrix'], $data['column'], 1, $data['insertIfMissing'], $data['overwrite']));
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            // #0 column required & present
            array(
                array(
                    'matrix'          => array(array('foo' => 2), array()),
                    'column'          => 'foo',
                    'insertIfMissing' => true,
                    'overwrite'       => true,
                    'expResult'       => array(array('foo' => 1), array('foo' => 1))
                )
            ),
            // #1 column not required & not present
            array(
                array(
                    'matrix'          => array(array('foo' => 2), array()),
                    'column'          => 'foo',
                    'insertIfMissing' => false,
                    'overwrite'       => false,
                    'expResult'       => array(array('foo' => 2), array())
                )
            )
        );
    }
}