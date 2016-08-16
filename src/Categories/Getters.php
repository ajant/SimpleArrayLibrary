<?php

namespace SimpleArrayLibrary\Categories;

use InvalidArgumentException;
use UnexpectedValueException;

trait Getters
{
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
     * Selects random sub array
     *
     * @param array $array
     * @param int $numberOfRequiredElements
     *
     * @return array
     * @throws InvalidArgumentException
     */
    public static function selectRandomArrayElements(array $array, $numberOfRequiredElements)
    {
        // validation, must be positive int or 0
        if (!self::isLogicallyCastableToInt($numberOfRequiredElements)) {
            throw new InvalidArgumentException('Number of requested elements parameter must be a positive integer');
        }
        if ($numberOfRequiredElements <= 0) {
            throw new InvalidArgumentException('Number of requested elements parameter must be a positive integer');
        }

        $selected = $array;
        if (count($array) > $numberOfRequiredElements) {
            // select required number of random keys
            $selectedKeys = array_rand($array, $numberOfRequiredElements);
            $selectedKeys = $numberOfRequiredElements == 1 ? [$selectedKeys] : $selectedKeys;
            // select only array members with selected random keys
            $selected = array_intersect_key($array, array_fill_keys($selectedKeys, null));
        }

        return $selected;
    }
}