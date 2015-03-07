SimpleArrayLibrary
==================
[![Build Status](https://travis-ci.org/ajant/SimpleArrayLibrary.svg?branch=master)](https://travis-ci.org/ajant/SimpleArrayLibrary)

Library containing convenient array handling methods.
These are methods that I needed to create for myself during work on various projects, If you have any methods you'd like to see added, let me know:
ajant.github@gmail.com

Requirements
============

You'll need: PHP version 4+

Quickstart
==========
Install the latest version with composer:
```
require "ajant/simple-array-library"
```
Auto-load the library:
```
use SimpleArrayLibrary/SimpleArrayLibrary
```
and you're ready to go.

Usage examples
==============
allElementsEqual
----------------
```
SimpleArrayLibrary::allElementsEqual(array(1, 1)); // true
SimpleArrayLibrary::allElementsEqual(array(1, 2)); // false
SimpleArrayLibrary::allElementsEqual(array(1, 1), 1); // true
SimpleArrayLibrary::allElementsEqual(array(1, 1) 2); // false
```
countMaxDepth
-------------
Second parameter must be an integer, or exception is thrown.
This is a recursive method, second parameter is used for recursive calls and should not be used from the outside of the method.
```
SimpleArrayLibrary::countMaxDepth(array()); // 1
SimpleArrayLibrary::countMaxDepth(
    array(
        1,
        array()
    )
); // 2
SimpleArrayLibrary::countMaxDepth(1); // 0
SimpleArrayLibrary::countMaxDepth(array(), 1); // 2
```
countMinDepth
-------------
Second parameter must be an integer, or exception is thrown.
This is a recursive method, second parameter is used for recursive calls and should not be used from the outside of the method.
```
SimpleArrayLibrary::countMinDepth(array()); // 1
SimpleArrayLibrary::countMinDepth(
    array(
        1,
        array()
    )
); // 1
SimpleArrayLibrary::countMinDepth(1); // 0
SimpleArrayLibrary::countMinDepth(array(), 1); // 2
```
getColumns
----------
First parameter must be array of arrays (matrix) otherwise it makes no sense to search for columns & exception is thrown.
Second parameter must be an array of elements that could be used as array indexes, otherwise exception is thrown.
Third parameter must be a boolean, otherwise exception is thrown.
```
SimpleArrayLibrary::getColumns(
    array(
        array('a' => 1),
        array(1)
    ),
    array('a')
); // array('a' => array(1))
SimpleArrayLibrary::getColumns(
    array(
        array(1, 2, 3, 4),
        array(1, 2, 3, 4),
        array(1, 2, 3, 4)
    ),
    array(0 ,2)
) // array(0 => array(1, 1, 1), 2 => array(3, 3, 3))
SimpleArrayLibrary::getColumns(
    array(
        array('a' => 1),
        array(1)
    ),
    array('a'),
    true
); // UnexpectedValueException is thrown, not all rows have all required columns as was requested by the third parameter
```
getRectangularDimensions
------------------------
```
SimpleArrayLibrary::getRectangularDimensions
```
hasAllKeys
----------
```
SimpleArrayLibrary::hasAllKeys
```
hasAllValues
------------
```
SimpleArrayLibrary::hasAllValues
```
haveEqualKeys
-------------
```
SimpleArrayLibrary::haveEqualKeys
```
haveEqualValues
---------------
```
SimpleArrayLibrary::haveEqualValues
```
```
isAssociative
-------------
```
SimpleArrayLibrary::isAssociative
```
```
isSubArray
------------------------------
```
SimpleArrayLibrary::isSubArray
```