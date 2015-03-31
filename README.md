SimpleArrayLibrary
==============================
[![Build Status](https://travis-ci.org/ajant/SimpleArrayLibrary.svg?branch=master)](https://travis-ci.org/ajant/SimpleArrayLibrary)

Library containing convenient array handling methods.
These are methods that I needed to create for myself during work on various projects, If you have any methods you'd like to see added, let me know:
ajant.github@gmail.com

Requirements
==============================

You'll need: PHP version 5.4+

Quickstart
==============================
Install the latest version with composer:
```
require "ajant/simple-array-library": 1.*
```
Auto-load the library:
```
use SimpleArrayLibrary/SimpleArrayLibrary
```
and you're ready to go.

Usage examples
==============================
For additional help, look at the tests, additional input scenarios are tested.
allElementsEqual
------------------------------
Checks whether all elements of the array are equal and optionally if they are all equal to specified value.
```
SimpleArrayLibrary::allElementsEqual(array(1, 1)); // true
SimpleArrayLibrary::allElementsEqual(array(1, 2)); // false
SimpleArrayLibrary::allElementsEqual(array(1, 1), 1); // true
SimpleArrayLibrary::allElementsEqual(array(1, 1), 2); // false
```
countMaxDepth
------------------------------
Count maximum depth of the array (number of nested sub-arrays) recursively.

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
------------------------------
Count minimum depth of the array (number of nested sub-arrays) recursively.

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
------------------------------
Retrieves values of required columns out of the multi-dimensional array.

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
------------------------------
This method checks if array is "rectangular" or in other words, whether all sub-arrays have equal number of elements,
recursively, and how many elements there are at each level of recursion, if it is rectangular.
```
SimpleArrayLibrary::getRectangularDimensions(array(1)); // array(1)
SimpleArrayLibrary::getRectangularDimensions(array(1, array(1))); // -1, not "rectangular"
SimpleArrayLibrary::getRectangularDimensions(
    array(                    // 3 elements
        array(                // 1 element
            array(1, 2, 3, 4) // 4 elements
        ),
        array(                // 1 element
            array(1, 2, 3, 4) // 4 elements
        ),
        array(                // 1 element
            array(1, 2, 3, 4) // 4 elements
        )
    )
); // array(4, 1, 3)
```
hasAllKeys
------------------------------
Checks if all required keys are present inside an array, regardless of values.
```
SimpleArrayLibrary::hasAllKeys(array('a' => 1), array('a')); // true
SimpleArrayLibrary::hasAllKeys(array(), array()); // true
SimpleArrayLibrary::hasAllKeys(array('b' => 1), array('a', 'b')); // false
```
hasAllValues
------------------------------
Checks if all required values are present inside an array, regardless of keys.
```
SimpleArrayLibrary::hasAllValues(array('a' => 1), array(1)); // true
SimpleArrayLibrary::hasAllValues(array(), array()); // true
SimpleArrayLibrary::hasAllValues(array('b', 1), array('a', 'b')); // false
```
haveEqualKeys
------------------------------
Checks if two arrays have equal keys, regardless of values.
```
SimpleArrayLibrary::haveEqualKeys(array('a' => 1), array('a' => 2)); // true
SimpleArrayLibrary::haveEqualKeys(array(), array()); // true
SimpleArrayLibrary::haveEqualKeys(array(1, 'a' => 1), array(2)); // false
```
haveEqualValues
------------------------------
Checks if two arrays have equal values, regardless of keys.
```
SimpleArrayLibrary::haveEqualValues(array('a' => 1), array(1)); // true
SimpleArrayLibrary::haveEqualValues(array(), array()); // true
SimpleArrayLibrary::haveEqualValues(array(1), array(2)); // false
```
isAssociative
------------------------------
Checks whether array has any associative keys.
```
SimpleArrayLibrary::isAssociative(array('a' => 1, array(1))); // true
SimpleArrayLibrary::isAssociative(array(1, 1)); // false
```
isSubArray
------------------------------
Checks whether array is sub-array of the other array (whether all key-value pairs of sub-array are present in array).

Third parameter must be a boolean, otherwise exception is thrown. If third parameter is set to true, strict comparison is
used (===) when comparing array values, otherwise regular comparison is used (==).
```
SimpleArrayLibrary::isSubArray(array(2, 1), array(2)); // true
SimpleArrayLibrary::isSubArray(array('a' => 1, 'b' => array(1)), array('c' => 1)); // false
SimpleArrayLibrary::isSubArray(array('a' => 1, 'b' => array(1)), array('a' => 2)); // false
```
castColumns
------------------------------
Attempts to cast specified columns in all rows of the two dimensional array to specified type. Allowed types are represented by
constants: TYPE_INT, TYPE_STRING, TYPE_FLOAT, TYPE_BOOL, TYPE_ARRAY, TYPE_OBJECT. Any other type will cause exception to be thrown.
User should know how type casting works in PHP as this method provides no protection from possible casting errors.

Third parameter must be a boolean, otherwise exception is thrown. If third parameter is set to true, columns defined as keys in the
second parameter have to be present, otherwise exception is thrown.
```
SimpleArrayLibrary::castColumns(array(array('a' => '2')), array('a' => SimpleArrayLibrary::TYPE_INT)); // array(array('a' => 2))
SimpleArrayLibrary::castColumns(array(array()), array('a' => SimpleArrayLibrary::TYPE_INT), false); // array(array())
SimpleArrayLibrary::castColumns(array(array('a' => '1'), array('b' => 'foo')), array('a' => SimpleArrayLibrary::TYPE_INT), false); // array(array('a' => 1), array('b' => 'foo'))
```