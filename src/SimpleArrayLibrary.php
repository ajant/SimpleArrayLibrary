<?php

namespace SimpleArrayLibrary;

use SimpleArrayLibrary\Categories\Changers;
use SimpleArrayLibrary\Categories\Checkers;
use SimpleArrayLibrary\Categories\Counters;
use SimpleArrayLibrary\Categories\Getters;
use SimpleArrayLibrary\Categories\Inspectors;

class SimpleArrayLibrary
{
    use Changers, Checkers, Counters, Getters, Inspectors;

    const TYPE_INT = 'int';
    const TYPE_STRING = 'string';
    const TYPE_FLOAT = 'float';
    const TYPE_BOOL = 'bool';
    const TYPE_ARRAY = 'array';
    const TYPE_OBJECT = 'object';

    /**
     * Check whether casting a variable to int would conway useful information
     *
     * @param mixed $input
     *
     * @return bool
     */
    private static function isLogicallyCastableToInt($input)
    {
        return !is_bool($input) && filter_var($input, FILTER_VALIDATE_INT) !== false;
    }
}