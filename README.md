SimpleArrayLibrary
==============================
[![Build Status](https://travis-ci.org/ajant/SimpleArrayLibrary.svg?branch=master)](https://travis-ci.org/ajant/SimpleArrayLibrary)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ajant/SimpleArrayLibrary/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ajant/SimpleArrayLibrary/?branch=master)
[![Coverage Status](https://coveralls.io/repos/ajant/SimpleArrayLibrary/badge.svg?branch=master&service=github)](https://coveralls.io/github/ajant/SimpleArrayLibrary?branch=master)

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
require "ajant/simple-array-library": ~4.1.0
```
Auto-load the library:
```
use SimpleArrayLibrary/SimpleArrayLibrary
```
and you're ready to go.

Usage examples
==============================
For additional help, look at the tests, additional input scenarios are tested.
addConfigRow
------------------------------
Method is intended to remove need for configuration files that need to be parsed into php arrays, since that carries significant performance
penalties. It combines readability of ini file with speed of having configurations defined directly on php level.
First parameter represents configuration array, second parameter represents a numerical array (in case of associative array, exception
is thrown) of nested keys of the new configuration row. Third parameter represents the value that is being mapped.
property, that is being added. Method returns configuration with the new row added, or throws exception if the same combination of
keys has already been used.
```php
SimpleArrayLibrary::addConfigRow(array('foo' => array('baz' => 1)), array('foo', 'bar'), 2); // array('foo' => array('baz' => 1, 'bar' => 2))
$config = array();
$config = SimpleArrayLibrary::addConfigRow($config, array('foo', 'bar'), new stdClass());
$config = SimpleArrayLibrary::addConfigRow($config, array('foo', 'baz'), 1);
$config = SimpleArrayLibrary::addConfigRow($config, array('foo', 3), array(1, 2));
// $config = array('foo' => array('bar' => stdClass(), 'baz' => 1, 3 => array(1, 2)))
$config = SimpleArrayLibrary::addConfigRow($config, array('foo', 3), false); // exception because of repeated  array('foo', 3) path
```
allElementsEqual
------------------------------
Checks whether all elements of the array are equal and optionally if they are all equal to specified value.
```php
SimpleArrayLibrary::allElementsEqual(array(1, 1)); // true
SimpleArrayLibrary::allElementsEqual(array(1, 2)); // false
SimpleArrayLibrary::allElementsEqual(array(1, 1), 1); // true
SimpleArrayLibrary::allElementsEqual(array(1, 1), 2); // false
```
castColumns
------------------------------
Attempts to cast specified columns of all rows of the two dimensional array to specified type. Allowed types are represented by
constants: TYPE_INT, TYPE_STRING, TYPE_FLOAT, TYPE_BOOL, TYPE_ARRAY, TYPE_OBJECT. Any other type will cause exception to be thrown.
User should know how type casting works in PHP as this method provides no protection from possible casting errors.

Third parameter must be a boolean, otherwise exception is thrown. If third parameter is set to true, columns defined as keys in the
second parameter have to be present, otherwise exception is thrown.
```php
SimpleArrayLibrary::castColumns(array(array('a' => '2')), array('a' => SimpleArrayLibrary::TYPE_INT)); // array(array('a' => 2))
SimpleArrayLibrary::castColumns(array(array()), array('a' => SimpleArrayLibrary::TYPE_INT), false); // array(array())
SimpleArrayLibrary::castColumns(array(array('a' => '1'), array('b' => 'foo')), array('a' => SimpleArrayLibrary::TYPE_INT), false); // array(array('a' => 1), array('b' => 'foo'))
```
countMaxDepth
------------------------------
Count maximum depth of the array (number of nested sub-arrays) recursively. Library contains [non-recursive method](https://github.com/ajant/SimpleArrayLibrary/blob/master/README.md#countmaxdepthiterative) doing th same 
thing. Recursive method is faster, but in case of very deep arrays may cause memory usage problems.
```php
SimpleArrayLibrary::countMaxDepth(array()); // 1
SimpleArrayLibrary::countMaxDepth(array(1, array())); // 2
SimpleArrayLibrary::countMaxDepth(array(array('foo'))); // 2
```
countMaxDepthIterative
------------------------------
Count maximum depth of the array (number of nested sub-arrays). Library contains [recursive method](https://github.com/ajant/SimpleArrayLibrary/blob/master/README.md#countmaxdepth) doing th same thing. Recursive 
method is faster, but in case of very deep arrays may cause memory usage problems.
```php
SimpleArrayLibrary::countMaxDepthIterative(array()); // 1
SimpleArrayLibrary::countMaxDepthIterative(array(1, array())); // 2
SimpleArrayLibrary::countMaxDepthIterative(array(array('foo'))); // 2
```
countMinDepth
------------------------------
Count minimum depth of the array (number of nested sub-arrays) recursively.

Second parameter must be an integer, or exception is thrown.
This is a recursive method, second parameter is used for recursive calls and should not be used from the outside of the method.
```php
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
deleteColumns
------------------------------
Deletes values to columns of the multi-dimensional array (is meant for two-dimensional arrays in particular, will work for three or more
dimension, but will only change elements on the second level, is not recursive)
```php
SimpleArrayLibrary::deleteColumns(array(array('foo' => 2), array()), array('foo')); // array(array(), array())
SimpleArrayLibrary::deleteColumns(array(array(), array()), array('foo')); // array(array(), array())
SimpleArrayLibrary::deleteColumns(array(array('foo' => 2, 'bar' => 1), array()), array('foo', 'bar')); // array(array(), array())
```
getColumns
------------------------------
Retrieves values of required columns out of the multi-dimensional array.

First parameter must be array of arrays (matrix) otherwise it makes no sense to search for columns & exception is thrown.

Second parameter must be an array of elements that could be used as array indexes, otherwise exception is thrown.

Third parameter must be a boolean, otherwise exception is thrown.
```php
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
```php
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
```php
SimpleArrayLibrary::hasAllKeys(array('a' => 1), array('a')); // true
SimpleArrayLibrary::hasAllKeys(array(), array()); // true
SimpleArrayLibrary::hasAllKeys(array('b' => 1), array('a', 'b')); // false
```
hasAllValues
------------------------------
Checks if all required values are present inside an array, regardless of keys. Values must not be arrays.
```php
SimpleArrayLibrary::hasAllValues(array('a' => 1), array(1)); // true
SimpleArrayLibrary::hasAllValues(array(), array()); // true
SimpleArrayLibrary::hasAllValues(array('b', 1), array('a', 'b')); // false
```
hasAllValuesMultiDimensional
------------------------------
Checks if all required values are present inside an array, regardless of keys. Values may be arrays.
```php
SimpleArrayLibrary::hasAllValuesMultiDimensional(array('a' => array(1)), array(array(1))); // true
SimpleArrayLibrary::hasAllValuesMultiDimensional(array(array()), array(array())); // true
SimpleArrayLibrary::hasAllValuesMultiDimensional(array('b', 1), array('a', 'b')); // false
```
hasOnlyKeys
------------------------------
Checks if all required keys are present inside an array, and no other keys.
```php
SimpleArrayLibrary::hasOnlyKeys(array('a' => 1, 2), array('a', 0)); // true
SimpleArrayLibrary::hasOnlyKeys(array('b' => 1, 1), array('b', 0, 1)); // false
SimpleArrayLibrary::hasOnlyKeys(array('b' => 1, 1), array('b')); // false
```
haveSameKeys
------------------------------
Checks if two arrays have equal keys, regardless of values.
```php
SimpleArrayLibrary::haveSameKeys(array('a' => 1), array('a' => 2)); // true
SimpleArrayLibrary::haveSameKeys(array(), array()); // true
SimpleArrayLibrary::haveSameKeys(array(1, 'a' => 1), array(2)); // false
```
haveSameValues
------------------------------
Checks if two arrays have equal values, regardless of keys.
```php
SimpleArrayLibrary::haveSameValues(array('a' => 1), array(1)); // true
SimpleArrayLibrary::haveSameValues(array(), array()); // true
SimpleArrayLibrary::haveSameValues(array(1), array(2)); // false
```
insertSubArray
------------------------------
Inserts the sub-array into the array in the place to which sub-array's keys point to

Third and forth parameters must be booleans, otherwise exception is thrown. If third parameter is set to true, insertion will overwrite
existing value inside the array, pointed to the sub-array's keys, if any. If third parameter is set to true, forth parameter is not used.
If forth parameter is set to true nad third parameter is set to false, existing value will be left unchanged, but if both third and
forth parameters were set to false and sub-array keys point to already existing value, exception will be thrown
```php
SimpleArrayLibrary::insertSubArray(array('foo' => 1), array('bar' => 2)); // array('foo' => 1, 'bar' => 2)
SimpleArrayLibrary::insertSubArray(array('foo' => 1), array('foo' => 2), true, false); // array('foo' => 2)
SimpleArrayLibrary::insertSubArray(array('foo' => 1), array('foo' => 2), false, true); // array('foo' => 1)
SimpleArrayLibrary::insertSubArray(array('foo' => 1), array('foo' => 2), false, false); // exception
```
isAssociative
------------------------------
Checks whether array has any associative keys.
```php
SimpleArrayLibrary::isAssociative(array('a' => 1, array(1))); // true
SimpleArrayLibrary::isAssociative(array(1, 1)); // false
SimpleArrayLibrary::isAssociative(array()); // false
```
isNumeric
------------------------------
Checks whether array has all numeric keys starting with zero and progressing by one for each new element.
```php
SimpleArrayLibrary::isNumeric(array('a' => 1, array(1))); // false
SimpleArrayLibrary::isNumeric(array(1, 1)); // true
SimpleArrayLibrary::isNumeric(array()); // false
```
isStructureSame
------------------------------
Checks whether 2 arrays have same structure (depth and keys). Values of leaf nodes are ignored, only keys are compared.
```php
SimpleArrayLibrary::isStructureSame(1, 'a'); // true
SimpleArrayLibrary::isStructureSame(array(1, array(1)), array(2, array(3)); // true
SimpleArrayLibrary::isStructureSame(array(1, array(1)), array(1, 1)); // false
SimpleArrayLibrary::isStructureSame(array(), array()); // true
```
isSubArray
------------------------------
Checks whether array is sub-array of the other array (whether all key-value pairs of sub-array are present in array).

Third parameter must be a boolean, otherwise exception is thrown. If third parameter is set to true, strict comparison is
used (===) when comparing array values, otherwise regular comparison is used (==).
```php
SimpleArrayLibrary::isSubArray(array(2, 1), array(2)); // true
SimpleArrayLibrary::isSubArray(array('a' => 1, 'b' => array(1)), array('c' => 1)); // false
SimpleArrayLibrary::isSubArray(array('a' => 1, 'b' => array(1)), array('a' => 2)); // false
```
selectRandomArrayElements
------------------------------
Select sub-array of random elements. Keys association is preserved. If required number of random elements is equal or bigger then number
of original array members, entire array is returned.

Second parameter must be positive integer or string representation of the positive integer, otherwise exception is thrown.  
```php
SimpleArrayLibrary::selectRandomArrayElements(array('foo' => 2), 1); // array('foo' => 2)
SimpleArrayLibrary::selectRandomArrayElements(array(1, 2), 1); // array(1) OR array(1 => 2)
SimpleArrayLibrary::selectRandomArrayElements(array('foo' => 2, 'bar'), 3); // array('foo' => 2, 'bar')
```
setColumn
------------------------------
Sets values to columns of the multi-dimensional array (is meant for two-dimensional arrays in particular, will work for three or more
dimension, but will only change elements on the second level) to the specified value

Forth and fifth parameters must be booleans, otherwise exception is thrown. If forth parameter is set to true, column will be added to
the rows in which it's missing. If fifth parameter is set to true, value of the column will be overwritten in rows in which it already
exists
```php
SimpleArrayLibrary::setColumn(array(array('foo' => 2), array()), 'foo', 1); // array(array('foo' => 1), array('foo' => 1))
SimpleArrayLibrary::setColumn(array(array('foo' => 2), array()), 'foo', 1, false, false); // array(array('foo' => 2), array())
SimpleArrayLibrary::setColumn(array(array('foo' => 2), array()), 'foo', 1, true, false); // array(array('foo' => 2), array('foo' => 1))
```
transpose
------------------------------
Simple matrix transpose

Meant for, and tested with, simple two dimentional matrix.
```php
SimpleArrayLibrary::transpose([[1,2,3], [4,5,6]]); // [[1,4], [2,5], [3,6]]
```