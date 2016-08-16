<?php

namespace SimpleArrayLibrary\Categories;

trait Inspectors
{
    /**
     * Checks if $array's keys contain all of $subArray's values
     *
     * @param array $haystack
     * @param array $needles
     *
     * @return bool
     */
    public static function hasAllKeys(array $haystack, array $needles)
    {
        return self::hasAllValues(array_keys($haystack), $needles);
    }

    /**
     * Checks if $array's keys contain all of $subArray's values
     *
     * @param array $haystack
     * @param array $needles
     *
     * @return bool
     */
    public static function hasAllValues(array $haystack, array $needles)
    {
        return array_diff($needles, $haystack) ? false : true;
    }

    /**
     * Checks if $array's keys contain all of $subArray's values
     *
     * @param array $haystack
     * @param array $needles
     *
     * @return bool
     */
    public static function hasAllValuesMultiDimensional(array $haystack, array $needles)
    {
        $return = true;
        foreach ($needles as $needle) {
            if (!in_array($needle, $haystack)) {
                $return = false;
                break;
            }
        }

        return $return;
    }

    /**
     * Checks whether array has only provided keys as indexes
     *
     * @param array $haystack
     * @param array $needles
     *
     * @return bool
     */
    public static function hasOnlyKeys(array $haystack, array $needles)
    {
        return self::haveSameKeys($haystack, array_flip($needles));
    }

    /**
     * Checks if two arrays have all equal keys
     *
     * @param array $array1
     * @param array $array2
     *
     * @return boolean
     */
    public static function haveSameKeys(array $array1, array $array2)
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
    public static function haveSameValues($array1, $array2)
    {
        return self::hasAllValues($array1, $array2) && self::hasAllValues($array2, $array1) ? true : false;
    }
}