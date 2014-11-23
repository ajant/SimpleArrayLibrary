<?php

namespace simpleArrayLibrary;

class SimpleArrayLibrary
{
    /**
     * Checks if an array is rectangular array and returns dimensions or -1 if it's not rectangular
     *
     * @param array $array
     *
     * @return int|array
     */
    public static function getRectangularDimensions(array $array)
    {
        $allArrays = array_map('is_array', $array);
        // all elements are arrays, iterate through them and call the static function recursively
        if (self::allElementsEqual($allArrays, true)) {
            $elementsPerArray = [];
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

                return $return;
            }
        } // none of the elements are arrays, return number of elements of the "bottom" array
        elseif (self::allElementsEqual($allArrays, false)) {
            return [0 => count($array)];
        } // some elements are arrays and some are not
        else {
            return -1;
        }

    }

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
        // if both arguments have been passed, use value argument (regardless of whether it is null or not
        if (func_num_args() == 2) {
            $compareAgainst = $value;
        } // only one argument has been passed, so compare elements only to each other
        else {
            $compareAgainst = reset($array);
        }
        foreach ($array as $element) {
            if ($compareAgainst != $element) {
                return false;
            }
        }

        return true;
    }

    /**
     * Extracts a column from an array
     *
     * @param array  $array
     * @param string $column
     *
     * @return array
     */
    public static function getColumn(array $array, $column)
    {
        $return = [];
        foreach ($array as $key => $row) {
            if (isset($row[$column]) || array_key_exists($column, $row)) {
                $return[$key] = $row[$column];
            } else {
                return false;
            }
        }

        return $return;
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
     * Counts maximum array depth
     *
     * @param mixed $potentialArray
     * @param int   $depth
     *
     * @return int
     * @throws \InvalidArgumentException
     */
    public static function countMaxDepth($potentialArray, $depth = 0)
    {
        // validation, must be positive int or 0
        if (!preg_match('/^[1-9]\d*$|^0$/', $depth)) {
            throw new \InvalidArgumentException('Depth parameter must be an integer');
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
     * Checks if $array's keys contain all of $subArray's values
     *
     * @param array $array
     * @param array $keys
     *
     * @return bool
     */
    public static function hasAllKeys(array $array, array $keys)
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $array)) {
                return false;
            }
        }

        return true;
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
        if (self::hasAllKeys($array1, array_keys($array2)) && self::hasAllKeys($array2, array_keys($array1))) {
            return true;
        } else {
            return false;
        }
    }
}