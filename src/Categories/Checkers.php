<?php

namespace SimpleArrayLibrary\Categories;

use InvalidArgumentException;

trait Checkers
{
    /**
     * Checks if all elements of the array have same value
     *
     * @param array $haystack
     * @param mixed $needle
     *
     * @return boolean
     */
    public static function allElementsEqual(array $haystack, $needle = null)
    {
        $return = true;
        // if both arguments have been passed, use value argument (regardless of whether it is null or not
        if (func_num_args() == 2) {
            $compareAgainst = $needle;
        } // only one argument has been passed, so compare elements only to each other
        else {
            $compareAgainst = reset($haystack);
        }
        foreach ($haystack as $element) {
            if ($compareAgainst != $element) {
                $return = false;
                break;
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
     * Checks whether array is numeric
     *
     * @param array $array
     *
     * @return bool
     */
    public static function isNumeric(array $array)
    {
        return array_keys($array) == range(0, count($array) - 1);
    }

    /**
     * @param mixed $input1
     * @param mixed $input2
     *
     * @return bool
     */
    public static function isStructureSame($input1, $input2)
    {
        $return = true;
        if (is_array($input1) && is_array($input2)) {
            if (!self::compareArrays($input1, $input2) || !self::compareArrays($input2, $input1)) {
                $return = false;
            }
        } else {
            $return = !is_array($input1) && !is_array($input2);
        }

        return $return;
    }

    /**
     * @param array $input1
     * @param array $input2
     *
     * @return bool
     */
    private static function compareArrays(array $input1, array $input2)
    {
        foreach ($input1 as $key => $value) {
            if (!array_key_exists($key, $input2)) {
                return false;
            } else {
                if (!self::isStructureSame($value, $input2[$key])) {
                    return false;
                }
            }
        }

        return true;
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