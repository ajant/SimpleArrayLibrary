<?php

use SimpleArrayLibrary\SimpleArrayLibrary;

class CastColumnsTest extends PHPUnit_Framework_TestCase
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
        if (!$data['allKeysMustBePresent']) {
            $this->assertEquals($data['expResult'], SimpleArrayLibrary::castColumns($data['matrix'], $data['columns'], $data['allKeysMustBePresent']));
        } else {
            $this->assertEquals($data['expResult'], SimpleArrayLibrary::castColumns($data['matrix'], $data['columns']));
        }
    }

    /**
     * @return array
     */
    public function getData()
    {
        $object1 = new stdClass();
        $object1->scalar = true;
        $object2 = new stdClass();
        $object2->scalar = 1;
        return array(
            // #0 columns required & present
            array(
                array(
                    'matrix'    => array(array('column1' => 1, 'column2' => '1'), array('column1' => true, 'column2' => 0)),
                    'columns'   => array('column1' => SimpleArrayLibrary::TYPE_STRING, 'column2' => SimpleArrayLibrary::TYPE_BOOL),
                    'allKeysMustBePresent' => true,
                    'expResult' => array(array('column1' => '1', 'column2' => true), array('column1' => '1', 'column2' => false))
                )
            ),
            // #1 column not required & not present
            array(
                array(
                    'matrix'    => array(array('column1' => 1, 'column2' => 1.1), array('column1' => '')),
                    'columns'   => array('column1' => SimpleArrayLibrary::TYPE_ARRAY, 'column2' => SimpleArrayLibrary::TYPE_INT),
                    'allKeysMustBePresent' => false,
                    'expResult' => array(array('column1' => array(1), 'column2' => 1), array('column1' => array('')))
                )
            ),
            // #2 column not required & present
            array(
                array(
                    'matrix'    => array(array('column1' => '1.1', 'column2' => true), array('column1' => 1, 'column2' => 1)),
                    'columns'   => array('column1' => SimpleArrayLibrary::TYPE_FLOAT, 'column2' => SimpleArrayLibrary::TYPE_OBJECT),
                    'allKeysMustBePresent' => true,
                    'expResult' => array(array('column1' => 1.1, 'column2' => $object1), array('column1' => 1, 'column2' => $object2))
                )
            )
        );
    }
}