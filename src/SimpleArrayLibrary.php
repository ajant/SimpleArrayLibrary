<?php

namespace SimpleArrayLibrary;

use InvalidArgumentException;
use UnexpectedValueException;

class SimpleArrayLibrary
{
    /**
     * @param array $config
     * @param array $keys
     * @param mixed $value
     *
     * @return array
     */
    public static function addConfigRow(array $config, array $keys, $value)
    {
        // validation
        if (self::isAssociative($keys)) {
            throw new UnexpectedValueException('Array of config keys must be numeric');
        }

        $row = $value;
        for ($i = count($keys) - 1; $i >= 0; $i--) {
            $row = [$keys[$i] => $row];
        }
        $config = self::insertSubArray($config, $row);

        return $config;
    }

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

    const TYPE_INT = 'int';
    const TYPE_STRING = 'string';
    const TYPE_FLOAT = 'float';
    const TYPE_BOOL = 'bool';
    const TYPE_ARRAY = 'array';
    const TYPE_OBJECT = 'object';

    /**
     * @param array $matrix
     * @param array $castMap
     * @param bool  $allKeysMustBePresent
     *
     * @return array
     */
    public static function castColumns(array $matrix, array $castMap, $allKeysMustBePresent = true)
    {
        if (!is_bool($allKeysMustBePresent)) {
            throw new InvalidArgumentException('Third parameter must be a boolean');
        }
        if (empty($matrix)) {
            return $matrix;
        }
        if (self::countMinDepth($matrix) < 2) {
            throw new UnexpectedValueException('Can not cast columns on one dimensional array');
        }

        foreach ($matrix as $key => $row) {
            foreach ($castMap as $column => $type) {
                if (isset($row[$column]) || array_key_exists($column, $row)) {
                    switch ($type) {
                        case self::TYPE_INT:
                            $matrix[$key][$column] = (int)$row[$column];
                            break;
                        case self::TYPE_STRING:
                            $matrix[$key][$column] = (string)$row[$column];
                            break;
                        case self::TYPE_FLOAT:
                            $matrix[$key][$column] = (float)$row[$column];
                            break;
                        case self::TYPE_BOOL:
                            $matrix[$key][$column] = (bool)$row[$column];
                            break;
                        case self::TYPE_ARRAY:
                            $matrix[$key][$column] = (array)$row[$column];
                            break;
                        case self::TYPE_OBJECT:
                            $matrix[$key][$column] = (object)$row[$column];
                            break;
                        default:
                            throw new UnexpectedValueException('Invalid type: ' . $type);
                    }
                } elseif ($allKeysMustBePresent) {
                    throw new UnexpectedValueException('Column: ' . $column . ' missing in row: ' . $key);
                }
            }
        }

        return $matrix;
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
        if (!is_int($depth) || $depth < 0) {
            throw new InvalidArgumentException('Depth parameter must be an integer');
        }

        $return = $depth;
        if (is_array($potentialArray)) {
            $return++;
            $childrenDepths = array();
            foreach ($potentialArray as $element) {
                $childrenDepths[] = self::countMaxDepth($element, $return);
            }
            $return = empty($childrenDepths) ? $return : max($childrenDepths);
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
        if (!is_int($depth) || $depth < 0) {
            throw new InvalidArgumentException('Depth parameter must be an integer');
        }

        $return = $depth;
        if (is_array($potentialArray)) {
            $return++;
            $childrenDepths = array();
            foreach ($potentialArray as $element) {
                $childrenDepths[] = self::countMinDepth($element, $return);
            }
            $return = empty($childrenDepths) ? $return : min($childrenDepths);
        }

        return $return;
    }

    /**
     * @param array $matrix
     * @param mixed $columns
     *
     * @return array
     */
    public static function deleteColumns(array $matrix, array $columns)
    {
        // validate input
        if (self::countMinDepth($matrix) < 2) {
            throw new UnexpectedValueException('Can not delete columns on one dimensional array');
        }
        if (self::countMinDepth($columns) != 1) {
            throw new InvalidArgumentException('Invalid column');
        }

        // remove columns in every row
        foreach ($matrix as $key => $row) {
            foreach ($columns as $column) {
                unset($matrix[$key][$column]);
            }
        }

        return $matrix;
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
     * @deprecated
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
     * @deprecated
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

    /**
     * @param mixed $array
     * @param mixed $subArray
     * @param bool  $overwrite
     * @param bool  $ignoreIfExists
     *
     * @return array
     */
    public static function insertSubArray($array, $subArray, $overwrite = false, $ignoreIfExists = false)
    {
        // validate
        if (!is_bool($overwrite)) {
            throw new InvalidArgumentException('Overwrite indicator must be a boolean');
        }
        if (!is_bool($ignoreIfExists)) {
            throw new InvalidArgumentException('Ignore if exists indicator must be a boolean');
        }

        if (!is_array($subArray) || !is_array($array)) {
            // $subArray[$key] is leaf of the array
            if ($overwrite) {
                $array = $subArray;
            } elseif (!$ignoreIfExists) {
                throw new UnexpectedValueException('Sub-array already exists');
            }
        } else {
            $key = key($subArray);
            if (isset($array[$key]) || array_key_exists($key, $array)) {
                $array[$key] = self::insertSubArray($array[$key], $subArray[$key], $overwrite, $ignoreIfExists);
            } else {
                $array[$key] = $subArray[$key];
            }
        }

        return $array;
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
        if (!preg_match('/^[1-9]\d*$/', $numberOfRequiredElements)) {
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

    /**
     * @param array $matrix
     * @param mixed $column
     * @param mixed $value
     * @param bool  $insertIfMissing
     * @param bool  $overwrite
     *
     * @return array
     */
    public static function setColumn(array $matrix, $column, $value, $insertIfMissing = true, $overwrite = true)
    {
        // validate input
        if (self::countMinDepth($matrix) < 2) {
            throw new UnexpectedValueException('Can not set columns on one dimensional array');
        }
        if (!is_scalar($column)) {
            throw new InvalidArgumentException('Invalid column');
        }
        if (!is_bool($insertIfMissing)) {
            throw new InvalidArgumentException('Insert if missing indicator must be a boolean');
        }
        if (!is_bool($overwrite)) {
            throw new InvalidArgumentException('Overwrite indicator must be a boolean');
        }

        foreach ($matrix as $key => $row) {
            if (isset($row[$column]) || array_key_exists($column, $row)) {
                $matrix[$key][$column] = ($overwrite ? $value : $matrix[$key][$column]);
            } elseif ($insertIfMissing) {
                $matrix[$key][$column] = $value;
            }
        }

        return $matrix;
    }
}
