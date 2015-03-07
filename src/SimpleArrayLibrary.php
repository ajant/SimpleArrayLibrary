<?php

namespace SimpleArrayLibrary;

use InvalidArgumentException;
use UnexpectedValueException;

class SimpleArrayLibrary
{
    /**
     * Checks if all elements of the array have same value
     *
     * @param array $array
     * @param mixed $value
     *
     * @return boolean
     */
    public static function allElementsEqual(array $array, $value = null)
    {
        $return = true;
        // if both arguments have been passed, use value argument (regardless of whether it is null or not
        if (func_num_args() == 2) {
            $compareAgainst = $value;
        } // only one argument has been passed, so compare elements only to each other
        else {
            $compareAgainst = reset($array);
        }
        foreach ($array as $element) {
            if ($compareAgainst != $element) {
                $return = false;
                break;
            }
        }

        return $return;
    }

    /**
     * Counts maximum array depth
     *
     * @param mixed $potentialArray
     * @param int   $depth
     *
     * @return int
     * @throws InvalidArgumentException
     */
    public static function countMaxDepth($potentialArray, $depth = 0)
    {
        // validation, must be positive int or 0
        if (!preg_match('/^[1-9]\d*$|^0$/', $depth)) {
            throw new InvalidArgumentException('Depth parameter must be an integer');
        }

        $return = $depth;
        if (is_array($potentialArray)) {
            foreach ($potentialArray as $element) {
                $result = self::countMaxDepth($element, $depth + 1);
                if ($result > $return) {
                    $return = $result;
                }
            }
        }

        return $return;
    }

    /**
     * Counts maximum array depth
     *
     * @param mixed $potentialArray
     * @param int   $depth
     *
     * @return int
     * @throws InvalidArgumentException
     */
    public static function countMinDepth($potentialArray, $depth = 0)
    {
        // validation, must be positive int or 0
        if (!preg_match('/^[1-9]\d*$|^0$/', $depth)) {
            throw new InvalidArgumentException('Depth parameter must be an integer');
        }

        $return = $depth;
        if (is_array($potentialArray)) {
            $childrenDepths = array();
            foreach ($potentialArray as $element) {
                $childrenDepths[] = self::countMinDepth($element, $depth + 1);
            }
            $return = min($childrenDepths);
        }

        return $return;
    }

    /**
     * Extracts a column from an array
     *
     * @param array $array
     * @param array $columns
     * @param bool  $allRowsMustHaveAllColumns
     *
     * @return array
     * @throws UnexpectedValueException
     */
    public static function getColumns(array $array, array $columns, $allRowsMustHaveAllColumns = false)
    {
        // validation
        foreach ($array as $key => $row) {
            if (!is_array($row)) {
                throw new UnexpectedValueException('Array element "' . $key . '" is not an array');
            }
        }
        foreach ($columns as $key => $column) {
            if (!is_string($column) && !is_numeric($column)) {
                throw new InvalidArgumentException('Invalid column type in columns array, index "' . $key . '"');
            }
        }
        if (!is_bool($allRowsMustHaveAllColumns)) {
            throw new InvalidArgumentException('allRowsMustHaveAllColumns flag must be boolean');
        }

        $return = array_fill_keys($columns, array());
        foreach ($array as $key => $row) {
            foreach ($columns as $column) {
                if (isset($row[$column]) || array_key_exists($column, $row)) {
                    $return[$column][$key] = $row[$column];
                } elseif ($allRowsMustHaveAllColumns) {
                    throw new UnexpectedValueException('Row "' . $key . '" is missing column: "' . $column . '"');
                }
            }
        }

        return $return;
    }

    /**
     * Checks if an array is rectangular array and returns dimensions or -1 if it's not rectangular
     *
     * @param array $array
     *
     * @return int|array
     */
    public static function getRectangularDimensions(array $array)
    {
        $return = -1;
        $allArrays = array_map('is_array', $array);
        // all elements are arrays, iterate through them and call the static function recursively
        if (self::allElementsEqual($allArrays, true)) {
            $elementsPerArray = array();
            foreach ($array as $row) {
                $noElements = self::getRectangularDimensions($row);
                if ($noElements == -1) {
                    return $noElements;
                }
                $elementsPerArray[] = $noElements;
            }
            if (!self::allElementsEqual($elementsPerArray)) {
                return -1;
            } else {
                $return   = reset($elementsPerArray);
                $return[] = count($elementsPerArray);
            }
        } // none of the elements are arrays, return number of elements of the "bottom" array
        elseif (self::allElementsEqual($allArrays, false)) {
            $return = array(0 => count($array));
        }

        return $return;
    }

    /**
     * Checks if $array's keys contain all of $subArray's values
     *
     * @param array $array
     * @param array $keys
     *
     * @return bool
     */
    public static function hasAllKeys(array $array, array $keys)
    {
        return self::hasAllValues(array_keys($array), $keys);
    }

    /**
     * Checks if $array's keys contain all of $subArray's values
     *
     * @param array $array
     * @param array $values
     *
     * @return bool
     */
    public static function hasAllValues(array $array, array $values)
    {
        return array_diff($values, $array) ? false : true;
    }

    /**
     * Checks if two arrays have all equal keys
     *
     * @param array $array1
     * @param array $array2
     *
     * @return boolean
     */
    public static function haveEqualKeys(array $array1, array $array2)
    {
        return self::hasAllKeys($array1, array_keys($array2)) && self::hasAllKeys($array2, array_keys($array1)) ? true : false;
    }

    /**
     * Check if two arrays have all equal values
     *
     * @param array $array1
     * @param array $array2
     *
     * @return bool
     */
    public static function haveEqualValues($array1, $array2)
    {
        return self::hasAllValues($array1, $array2) && self::hasAllValues($array2, $array1) ? true : false;
    }

    /**
     * Checks whether array is associative or numeric
     *
     * @param array $array
     *
     * @return bool
     */
    public static function isAssociative(array $array)
    {
        return (bool)count(array_filter(array_keys($array), 'is_string'));
    }

    /**
     * Checks whether $subArray is contained in $array
     *
     * @param array $array
     * @param array $subArray
     * @param bool  $strictComparison
     *
     * @return bool
     * @throws InvalidArgumentException
     */
    public static function isSubArray(array $array, array $subArray, $strictComparison = true)
    {
        if (!is_bool($strictComparison)) {
            throw new InvalidArgumentException('Strict comparison parameter must be a boolean');
        }

        $return = true;
        foreach ($subArray as $key => $value) {
            if (isset($array[$key]) || array_key_exists($key, $array)) {
                $check = $strictComparison ? $array[$key] !== $subArray[$key] : $array[$key] != $subArray[$key];
                if ($check) {
                    $return = false;
                    break;
                }
            } else {
                $return = false;
                break;
            }
        }

        return $return;
    }
}