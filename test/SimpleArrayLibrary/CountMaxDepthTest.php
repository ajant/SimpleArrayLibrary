<?php

use \SimpleArrayLibrary\SimpleArrayLibrary;

/**
 * Tests countMaxDepth method with valid data
 */
class CountMaxDepthTest extends PHPUnit_Framework_TestCase
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
        $this->assertEquals($data['expResult'], SimpleArrayLibrary::countMaxDepth($data['array'], $data['depth']));
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            // #0 rectangular
            [
                [
                    'array'     => [1, 1],
                    'depth'     => 1,
                    'expResult' => 2
                ]
            ],
            // #1 non-rectangular
            [
                [
                    'array'     => [1, [1]],
                    'depth'     => 0,
                    'expResult' => 2
                ]
            ],
            // #2 non-array
            [
                [
                    'array'     => 1,
                    'depth'     => 1,
                    'expResult' => 1
                ]
            ]
        ];
    }
}